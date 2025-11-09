<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LessonProgressController extends Controller
{
    /**
     * Display a listing of all available modules for the member.
     */
    public function index()
    {
        $member = Auth::guard('member')->user();

        // Get all published classes with their modules and member's enrollment data
        $classes = ClassModel::with([
            'categories',
            'modules.lessons',
            'enrollments' => function ($query) use ($member) {
                $query->where('member_id', $member->id)->active();
            }
        ])
            ->published()
            ->get();

        return view('member.courses.index', compact('classes'));
    }

    /**
     * Display the specified course with modules and lessons.
     */
    public function show(ClassModel $class)
    {
        $member = Auth::guard('member')->user();

        // Load class with categories
        $class->load('categories');

        // Check if member is enrolled in this class
        $enrollment = Enrollment::forMember($member->id)
            ->where('class_id', $class->id)
            ->active()
            ->first();

        // Get modules with lessons
        $modules = Module::with(['lessons' => function ($query) {
            $query->ordered();
        }])
            ->where('class_id', $class->id)
            ->orderBy('position')
            ->get();

        // Get lesson progress for this enrollment (if enrolled)
        $lessonProgress = collect();
        if ($enrollment) {
            $lessonProgress = LessonProgress::with('lesson')
                ->forEnrollment($enrollment->id)
                ->get();
        }

        return view('member.courses.show', compact('class', 'enrollment', 'modules', 'lessonProgress'));
    }

    /**
     * Display the specified lesson.
     */
    public function showLesson(ClassModel $class, Module $module, Lesson $lesson)
    {
        $member = Auth::guard('member')->user();

        // Check if member is enrolled in this class (auto-enroll if not)
        $enrollment = Enrollment::forMember($member->id)
            ->where('class_id', $class->id)
            ->active()
            ->first();

        if (!$enrollment) {
            // Auto-enroll member in join-based system
            $enrollment = Enrollment::create([
                'member_id' => $member->id,
                'class_id' => $class->id,
                'enrolled_at' => now(),
                'status' => 'active',
            ]);
        }

        // Verify lesson belongs to the module and class
        if ($lesson->module_id !== $module->id || $module->class_id !== $class->id) {
            abort(404);
        }

        // Load questions and options for quiz support
        $lesson->load(['questions.options']);

        // Get or create lesson progress
        $progress = LessonProgress::firstOrCreate([
            'enrollment_id' => $enrollment->id,
            'lesson_id' => $lesson->id,
        ]);

        // Get all lessons in this module for navigation
        $moduleLessons = $module->lessons()->ordered()->get();

        // Find current lesson index for navigation
        $currentIndex = $moduleLessons->search(function ($item) use ($lesson) {
            return $item->id === $lesson->id;
        });

        $previousLesson = $currentIndex > 0 ? $moduleLessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $moduleLessons->count() - 1 ? $moduleLessons[$currentIndex + 1] : null;

        // Load lesson with questions
        $lesson->load('questions.options');

        return view('member.courses.lesson', compact(
            'class',
            'module',
            'lesson',
            'progress',
            'enrollment',
            'moduleLessons',
            'currentIndex',
            'previousLesson',
            'nextLesson'
        ));
    }

    /**
     * Mark a lesson as completed.
     */
    public function completeLesson(Request $request, ClassModel $class, Module $module, Lesson $lesson)
    {
        $member = Auth::guard('member')->user();

        // Check if member is enrolled in this class (auto-enroll if not)
        $enrollment = Enrollment::forMember($member->id)
            ->where('class_id', $class->id)
            ->active()
            ->first();

        if (!$enrollment) {
            // Auto-enroll member in join-based system
            $enrollment = Enrollment::create([
                'member_id' => $member->id,
                'class_id' => $class->id,
                'enrolled_at' => now(),
                'status' => 'active',
            ]);
        }

        // Verify lesson belongs to the module and class
        if ($lesson->module_id !== $module->id || $module->class_id !== $class->id) {
            return response()->json(['error' => __('ecourse.invalid_lesson')], 404);
        }

        try {
            DB::beginTransaction();

            // Get or create lesson progress
            $progress = LessonProgress::firstOrCreate([
                'enrollment_id' => $enrollment->id,
                'lesson_id' => $lesson->id,
            ]);

            // Mark as completed if not already completed
            if (!$progress->isCompleted()) {
                $pointsToAward = $request->input('points', 10); // Default 10 points
                $progress->markCompleted($pointsToAward);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('ecourse.lesson_completed'),
                'points_earned' => $progress->points_earned,
                'total_points' => $enrollment->fresh()->total_points,
                'completion_percentage' => $enrollment->fresh()->completion_percentage,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => __('common.error')], 500);
        }
    }

    /**
     * Join member to a course (simplified enrollment).
     */
    public function enroll(Request $request, ClassModel $class)
    {
        $member = Auth::guard('member')->user();

        DB::beginTransaction();

        try {
            // Check if already joined
            $existingEnrollment = $member->enrollments()
                ->where('class_id', $class->id)
                ->first();

            if ($existingEnrollment) {
                if ($existingEnrollment->is_active) {
                    return redirect()->route('member.courses.show', $class)
                        ->with('info', __('ecourse.already_enrolled'));
                } else {
                    // Reactivate enrollment
                    $existingEnrollment->update(['is_active' => true]);
                    DB::commit();
                    return redirect()->route('member.courses.show', $class)
                        ->with('success', __('ecourse.enrollment_reactivated'));
                }
            }

            // Create new enrollment (join)
            $enrollment = Enrollment::create([
                'member_id' => $member->id,
                'class_id' => $class->id,
                'enrolled_at' => now(),
                'is_active' => true,
            ]);

            // Create lesson progress entries for all lessons in the class
            $lessons = Lesson::whereHas('module', function ($query) use ($class) {
                $query->where('class_id', $class->id);
            })->get();

            foreach ($lessons as $lesson) {
                LessonProgress::create([
                    'enrollment_id' => $enrollment->id,
                    'lesson_id' => $lesson->id,
                    'completed' => false,
                    'points_awarded' => false,
                    'points_earned' => 0,
                ]);
            }

            DB::commit();

            return redirect()->route('member.courses.show', $class)
                ->with('success', __('ecourse.enrollment_success'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred while joining the course.');
        }
    }

    /**
     * Get progress statistics for the member.
     */
    public function getProgress()
    {
        $member = Auth::guard('member')->user();

        $stats = [
            'total_enrollments' => Enrollment::forMember($member->id)->active()->count(),
            'completed_courses' => Enrollment::forMember($member->id)->completed()->count(),
            'total_points' => Enrollment::forMember($member->id)->sum('total_points'),
            'completed_lessons' => LessonProgress::whereHas('enrollment', function ($query) use ($member) {
                $query->forMember($member->id);
            })->completed()->count(),
        ];

        return response()->json($stats);
    }
}
