<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'member_id',
        'class_id',
        'enrolled_at',
        'completed_at',
        'total_points',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
        'is_active' => 'boolean',
        'total_points' => 'integer',
    ];

    /**
     * Get the member that owns the enrollment.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the class that owns the enrollment.
     */
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    /**
     * Get the lesson progress for this enrollment.
     */
    public function lessonProgress()
    {
        return $this->hasMany(LessonProgress::class);
    }

    /**
     * Scope to get only active enrollments.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get completed enrollments.
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_at');
    }

    /**
     * Scope to get enrollments for a specific member.
     */
    public function scopeForMember($query, $memberId)
    {
        return $query->where('member_id', $memberId);
    }

    /**
     * Get the completion percentage for this enrollment.
     */
    public function getCompletionPercentageAttribute()
    {
        $totalLessons = $this->class->modules()
            ->with('lessons')
            ->get()
            ->sum(function ($module) {
                return $module->lessons->count();
            });

        if ($totalLessons === 0) {
            return 0;
        }

        $completedLessons = $this->lessonProgress()
            ->where('completed', true)
            ->count();

        return round(($completedLessons / $totalLessons) * 100, 2);
    }

    /**
     * Check if the enrollment is completed.
     */
    public function isCompleted()
    {
        return !is_null($this->completed_at);
    }

    /**
     * Mark the enrollment as completed if all lessons are done.
     */
    public function checkAndMarkCompleted()
    {
        if ($this->completion_percentage >= 100 && !$this->isCompleted()) {
            $this->update(['completed_at' => now()]);
        }
    }
}
