<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonCreateRequest;
use App\Http\Requests\LessonUpdateRequest;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class LessonController extends Controller
{
    /**
     * Display a listing of the lessons.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $lessons = Lesson::with(['module', 'module.class'])->select(['id', 'module_id', 'title', 'duration', 'position', 'type', 'created_at']);

            return DataTables::of($lessons)
                ->addIndexColumn()
                ->addColumn('module_title', function ($lesson) {
                    return $lesson->module ? $lesson->module->title : '-';
                })
                ->addColumn('class_title', function ($lesson) {
                    return $lesson->module && $lesson->module->class ? $lesson->module->class->title : '-';
                })
                ->addColumn('formatted_duration', function ($lesson) {
                    return $lesson->formatted_duration;
                })
                ->addColumn('type_badge', function ($lesson) {
                    if (!$lesson->type) {
                        return '<span class="badge bg-secondary">-</span>';
                    }
                    $badgeClass = match ($lesson->type) {
                        'video' => 'bg-primary',
                        'text' => 'bg-info',
                        'quiz' => 'bg-warning',
                        'assignment' => 'bg-danger',
                        default => 'bg-secondary'
                    };
                    return '<span class="badge ' . $badgeClass . '">' . ucfirst($lesson->type) . '</span>';
                })
                ->addColumn('action', function ($lesson) {
                    $actions = '<div class="btn-group" role="group">';
                    $actions .= '<a href="' . route('admin.lessons.show', $lesson->id) . '" class="btn btn-info btn-sm">' . __('common.view') . '</a>';
                    $actions .= '<a href="' . route('admin.lessons.edit', $lesson->id) . '" class="btn btn-warning btn-sm">' . __('common.edit') . '</a>';
                    $actions .= '<button class="btn btn-danger btn-sm btn-delete" data-title="' . __('datatable.lessons.delete_title') . '" data-item="' . $lesson->title . '" data-url="' . route('admin.lessons.destroy', $lesson->id) . '">' . __('common.delete') . '</button>';
                    $actions .= '</div>';
                    return $actions;
                })
                ->editColumn('created_at', function ($lesson) {
                    return $lesson->created_at->format('Y-m-d H:i:s');
                })
                ->rawColumns(['type_badge', 'action'])
                ->make(true);
        }

        return view('admin.lessons.index');
    }

    /**
     * Show the form for creating a new lesson.
     */
    public function create()
    {
        $modules = Module::with('class')->orderBy('title')->get();
        return view('admin.lessons.create', compact('modules'));
    }

    /**
     * Store a newly created lesson in storage.
     */
    public function store(LessonCreateRequest $request)
    {
        $validated = $request->validated();

        // Handle video file upload
        if ($request->hasFile('video_file') && $validated['video_source'] === 'upload') {
            $validated['video_file'] = $request->file('video_file')->store('lessons/videos', 'public');
        }

        // Clear video fields based on source
        if ($validated['type'] === 'video') {
            if ($validated['video_source'] === 'youtube') {
                $validated['video_file'] = null;
            } elseif ($validated['video_source'] === 'upload') {
                $validated['youtube_url'] = null;
            }
        } else {
            // Clear all video fields if not a video lesson
            $validated['video_source'] = null;
            $validated['youtube_url'] = null;
            $validated['video_file'] = null;
        }

        // Auto-set position if not provided
        if (empty($validated['position'])) {
            $maxPosition = Lesson::where('module_id', $validated['module_id'])->max('position');
            $validated['position'] = ($maxPosition ?? 0) + 1;
        } else {
            // If position is specified, shift existing lessons at or after this position
            Lesson::where('module_id', $validated['module_id'])
                ->where('position', '>=', $validated['position'])
                ->increment('position');
        }

        $lesson = Lesson::create($validated);

        if ($validated['type'] === 'quiz') {
            return redirect()->route('admin.lessons.show', $lesson)
                ->with('success', 'Lesson created successfully.');
        }

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Lesson created successfully.');
    }

    /**
     * Display the specified lesson.
     */
    public function show(Lesson $lesson)
    {
        $lesson->load(['module', 'module.class', 'questions.options']);
        return view('admin.lessons.show', compact('lesson'));
    }

    /**
     * Show the form for editing the specified lesson.
     */
    public function edit(Lesson $lesson)
    {
        $modules = Module::with('class')->orderBy('title')->get();
        $lesson->load(['module', 'module.class']);
        return view('admin.lessons.edit', compact('lesson', 'modules'));
    }

    /**
     * Update the specified lesson in storage.
     */
    public function update(LessonUpdateRequest $request, Lesson $lesson)
    {
        $validated = $request->validated();

        // Handle video file upload
        if ($request->hasFile('video_file') && $validated['video_source'] === 'upload') {
            // Delete old video file if exists
            if ($lesson->video_file) {
                Storage::disk('public')->delete($lesson->video_file);
            }
            $validated['video_file'] = $request->file('video_file')->store('lessons/videos', 'public');
        }

        // Clear video fields based on source
        if ($validated['type'] === 'video') {
            if ($validated['video_source'] === 'youtube') {
                // Delete old video file if switching to YouTube
                if ($lesson->video_file) {
                    Storage::disk('public')->delete($lesson->video_file);
                }
                $validated['video_file'] = null;
            } elseif ($validated['video_source'] === 'upload') {
                $validated['youtube_url'] = null;
            }
        } else {
            // Clear all video fields if not a video lesson
            if ($lesson->video_file) {
                Storage::disk('public')->delete($lesson->video_file);
            }
            $validated['video_source'] = null;
            $validated['youtube_url'] = null;
            $validated['video_file'] = null;
        }

        $oldPosition = $lesson->position;
        $oldModuleId = $lesson->module_id;
        $newPosition = $validated['position'];
        $newModuleId = $validated['module_id'];

        // Auto-set position if not provided
        if (empty($newPosition)) {
            $maxPosition = Lesson::where('module_id', $newModuleId)->max('position');
            $newPosition = ($maxPosition ?? 0) + 1;
            $validated['position'] = $newPosition;
        }

        // Handle position updates within the same module
        if ($oldModuleId == $newModuleId && $oldPosition != $newPosition) {
            if ($newPosition < $oldPosition) {
                // Moving up: shift lessons down that are between new and old position
                Lesson::where('module_id', $newModuleId)
                    ->where('position', '>=', $newPosition)
                    ->where('position', '<', $oldPosition)
                    ->where('id', '!=', $lesson->id)
                    ->increment('position');
            } else {
                // Moving down: shift lessons up that are between old and new position
                Lesson::where('module_id', $newModuleId)
                    ->where('position', '>', $oldPosition)
                    ->where('position', '<=', $newPosition)
                    ->where('id', '!=', $lesson->id)
                    ->decrement('position');
            }
        }
        // Handle moving to different module
        else if ($oldModuleId != $newModuleId) {
            // Shift lessons up in old module that are after the old position
            Lesson::where('module_id', $oldModuleId)
                ->where('position', '>', $oldPosition)
                ->decrement('position');

            // Shift lessons down in new module that are at or after the new position
            Lesson::where('module_id', $newModuleId)
                ->where('position', '>=', $newPosition)
                ->increment('position');
        }

        $lesson->update($validated);

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Lesson updated successfully.');
    }

    /**
     * Remove the specified lesson from storage.
     */
    public function destroy(Lesson $lesson)
    {
        $moduleId = $lesson->module_id;
        $position = $lesson->position;

        // Delete video file if exists
        if ($lesson->video_file) {
            Storage::disk('public')->delete($lesson->video_file);
        }

        $lesson->delete();

        // Shift remaining lessons up to fill the gap
        Lesson::where('module_id', $moduleId)
            ->where('position', '>', $position)
            ->decrement('position');

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Lesson deleted successfully.');
    }

    /**
     * Search lessons for Select2 API
     */
    public function search(Request $request)
    {
        $term = $request->get('q');
        $moduleId = $request->get('module_id');
        $page = $request->get('page', 1);
        $perPage = 10;

        $query = Lesson::with(['module', 'module.class'])->select(['id', 'module_id', 'title', 'position', 'type'])
            ->when($term, function ($query, $term) {
                return $query->where('title', 'LIKE', "%{$term}%");
            })
            ->when($moduleId, function ($query, $moduleId) {
                return $query->where('module_id', $moduleId);
            })
            ->orderBy('position');

        $total = $query->count();
        $lessons = $query->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        $results = $lessons->map(function ($lesson) {
            $moduleTitle = $lesson->module ? $lesson->module->title : 'No Module';
            $classTitle = $lesson->module && $lesson->module->class ? $lesson->module->class->title : '';
            $displayText = $lesson->title . ' (' . $moduleTitle . ($classTitle ? ' - ' . $classTitle : '') . ')';

            return [
                'id' => $lesson->id,
                'text' => $displayText,
                'title' => $lesson->title,
                'position' => $lesson->position,
                'module_id' => $lesson->module_id,
                'type' => $lesson->type,
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => ($page * $perPage) < $total
            ]
        ]);
    }

    /**
     * Store a new question for the lesson.
     */
    public function storeQuestion(Request $request, Lesson $lesson)
    {
        $request->validate([
            'question' => 'required|string',
        ]);

        $maxPosition = Question::where('lesson_id', $lesson->id)->max('position');
        
        $question = Question::create([
            'lesson_id' => $lesson->id,
            'question' => $request->question,
            'position' => ($maxPosition ?? 0) + 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => __('questions.created_successfully'),
            'question' => $question->load('options'),
        ]);
    }

    /**
     * Update a question.
     */
    public function updateQuestion(Request $request, Question $question)
    {
        $request->validate([
            'question' => 'required|string',
        ]);

        $question->update([
            'question' => $request->question,
        ]);

        return response()->json([
            'success' => true,
            'message' => __('questions.updated_successfully'),
            'question' => $question->load('options'),
        ]);
    }

    /**
     * Delete a question.
     */
    public function destroyQuestion(Question $question)
    {
        $lessonId = $question->lesson_id;
        $position = $question->position;
        
        $question->delete();

        // Shift remaining questions up to fill the gap
        Question::where('lesson_id', $lessonId)
            ->where('position', '>', $position)
            ->decrement('position');

        return response()->json([
            'success' => true,
            'message' => __('questions.deleted_successfully'),
        ]);
    }

    /**
     * Store a new option for a question.
     */
    public function storeOption(Request $request, Question $question)
    {
        $request->validate([
            'option_text' => 'required|string',
            'is_correct' => 'boolean',
        ]);

        $maxPosition = QuestionOption::where('question_id', $question->id)->max('position');
        
        $option = QuestionOption::create([
            'question_id' => $question->id,
            'option_text' => $request->option_text,
            'is_correct' => $request->boolean('is_correct', false),
            'position' => ($maxPosition ?? 0) + 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => __('questions.option_created_successfully'),
            'option' => $option,
        ]);
    }

    /**
     * Update an option.
     */
    public function updateOption(Request $request, QuestionOption $option)
    {
        $request->validate([
            'option_text' => 'required|string',
            'is_correct' => 'boolean',
        ]);

        $option->update([
            'option_text' => $request->option_text,
            'is_correct' => $request->boolean('is_correct', false),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('questions.option_updated_successfully'),
            'option' => $option,
        ]);
    }

    /**
     * Delete an option.
     */
    public function destroyOption(QuestionOption $option)
    {
        $questionId = $option->question_id;
        $position = $option->position;
        
        $option->delete();

        // Shift remaining options up to fill the gap
        QuestionOption::where('question_id', $questionId)
            ->where('position', '>', $position)
            ->decrement('position');

        return response()->json([
            'success' => true,
            'message' => __('questions.option_deleted_successfully'),
        ]);
    }

    /**
     * Set an option as correct answer.
     */
    public function setCorrectOption(QuestionOption $option)
    {
        // First, unset all correct answers for this question
        QuestionOption::where('question_id', $option->question_id)
            ->update(['is_correct' => false]);

        // Set this option as correct
        $option->update(['is_correct' => true]);

        return response()->json([
            'success' => true,
            'message' => __('questions.correct_answer_set'),
            'option' => $option,
        ]);
    }
}
