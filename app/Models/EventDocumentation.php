<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EventDocumentation extends Model
{
    use HasFactory;

    protected $table = 'event_documentation';

    protected $fillable = [
        'event_id',
        'type',
        'file_path',
        'title',
        'description',
        'sort_order',
        'uploaded_by',
    ];

    // Relationships
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Scopes
    public function scopePhotos($query)
    {
        return $query->where('type', 'photo');
    }

    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }

    // Helper Methods
    public function getFileUrlAttribute()
    {
        if ($this->file_path && Storage::disk('public')->exists($this->file_path)) {
            return Storage::url($this->file_path);
        }
        return null;
    }

    public function getTypeBadgeAttribute()
    {
        $badges = [
            'photo' => '<span class="badge bg-primary"><i class="ti tabler-photo"></i> Photo</span>',
            'video' => '<span class="badge bg-info"><i class="ti tabler-video"></i> Video</span>',
        ];
        return $badges[$this->type] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    public function deleteFile()
    {
        if ($this->file_path && Storage::disk('public')->exists($this->file_path)) {
            Storage::disk('public')->delete($this->file_path);
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($documentation) {
            $documentation->deleteFile();
        });
    }
}
