<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the categories for the class.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'class_categories', 'class_id', 'category_id');
    }

    /**
     * Get the modules for the class.
     */
    public function modules()
    {
        return $this->hasMany(Module::class, 'class_id')->orderBy('position');
    }

    /**
     * Scope a query to only include published classes.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to only include draft classes.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Get the enrollments for the class.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }

    /**
     * Get active enrollments for the class.
     */
    public function activeEnrollments()
    {
        return $this->enrollments()->active();
    }

    /**
     * Get the members enrolled in this class.
     */
    public function enrolledMembers()
    {
        return $this->belongsToMany(Member::class, 'enrollments', 'class_id', 'member_id')
            ->withPivot('enrolled_at', 'completed_at', 'total_points', 'is_active')
            ->withTimestamps();
    }

    /**
     * Get total number of lessons in this class.
     */
    public function getTotalLessonsAttribute()
    {
        return $this->modules()->with('lessons')->get()->sum(function ($module) {
            return $module->lessons->count();
        });
    }

    /**
     * Get estimated duration in minutes for this class.
     */
    public function getEstimatedDurationAttribute()
    {
        return $this->modules()->with('lessons')->get()->sum(function ($module) {
            return $module->lessons->sum('duration');
        });
    }

    /**
     * Get formatted estimated duration.
     */
    public function getFormattedDurationAttribute()
    {
        $minutes = $this->estimated_duration;
        
        if ($minutes <= 0) {
            return '0 min';
        }
        
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        if ($hours > 0) {
            return $remainingMinutes > 0 ? "{$hours}h {$remainingMinutes}m" : "{$hours}h";
        }
        
        return "{$remainingMinutes}m";
    }
}
