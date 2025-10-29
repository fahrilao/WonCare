<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'module_id',
        'title',
        'content',
        'duration',
        'position',
        'type',
        'video_source',
        'youtube_url',
        'video_file',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'duration' => 'integer',
        'position' => 'integer',
    ];

    /**
     * Get the module that owns the lesson.
     */
    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    /**
     * Scope a query to order by position.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position', 'asc');
    }

    /**
     * Scope a query to filter by module.
     */
    public function scopeForModule($query, $moduleId)
    {
        return $query->where('module_id', $moduleId);
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get formatted duration in minutes and seconds.
     */
    public function getFormattedDurationAttribute()
    {
        if ($this->duration <= 0) {
            return '0:00';
        }
        
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        
        return sprintf('%d:%02d', $minutes, $seconds);
    }

    /**
     * Get YouTube video ID from URL.
     */
    public function getYoutubeVideoIdAttribute()
    {
        if (!$this->youtube_url) {
            return null;
        }

        // Extract video ID from various YouTube URL formats
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->youtube_url, $matches);
        
        return $matches[1] ?? null;
    }

    /**
     * Get YouTube embed URL.
     */
    public function getYoutubeEmbedUrlAttribute()
    {
        $videoId = $this->youtube_video_id;
        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
    }

    /**
     * Get YouTube thumbnail URL.
     */
    public function getYoutubeThumbnailAttribute()
    {
        $videoId = $this->youtube_video_id;
        return $videoId ? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg" : null;
    }

    /**
     * Check if lesson has video content.
     */
    public function hasVideo()
    {
        return $this->type === 'video' && 
               ($this->video_source === 'youtube' && $this->youtube_url) ||
               ($this->video_source === 'upload' && $this->video_file);
    }
}
