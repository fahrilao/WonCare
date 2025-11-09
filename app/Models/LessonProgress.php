<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonProgress extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lesson_progress';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enrollment_id',
        'lesson_id',
        'completed',
        'completed_at',
        'points_awarded',
        'points_earned',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'completed' => 'boolean',
        'completed_at' => 'datetime',
        'points_awarded' => 'boolean',
        'points_earned' => 'integer',
    ];

    /**
     * Get the enrollment that owns the lesson progress.
     */
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    /**
     * Get the lesson that owns the lesson progress.
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Scope to get only completed progress.
     */
    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    /**
     * Scope to get progress for a specific enrollment.
     */
    public function scopeForEnrollment($query, $enrollmentId)
    {
        return $query->where('enrollment_id', $enrollmentId);
    }

    /**
     * Scope to get progress for a specific lesson.
     */
    public function scopeForLesson($query, $lessonId)
    {
        return $query->where('lesson_id', $lessonId);
    }

    /**
     * Mark the lesson as completed and award points.
     */
    public function markCompleted($pointsToAward = 10)
    {
        $this->update([
            'completed' => true,
            'completed_at' => now(),
            'points_awarded' => true,
            'points_earned' => $pointsToAward,
        ]);

        // Update enrollment total points
        $this->enrollment->increment('total_points', $pointsToAward);

        // Check if enrollment should be marked as completed
        $this->enrollment->checkAndMarkCompleted();

        return $this;
    }

    /**
     * Check if the lesson progress is completed.
     */
    public function isCompleted()
    {
        return $this->completed;
    }

    /**
     * Get the member through enrollment relationship.
     */
    public function member()
    {
        return $this->hasOneThrough(Member::class, Enrollment::class, 'id', 'id', 'enrollment_id', 'member_id');
    }
}
