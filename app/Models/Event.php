<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'location',
        'meeting_link',
        'start_datetime',
        'end_datetime',
        'max_participants',
        'status',
        'banner_image',
        'require_rsvp',
        'send_reminder',
        'reminder_hours_before',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'require_rsvp' => 'boolean',
        'send_reminder' => 'boolean',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function rsvps()
    {
        return $this->hasMany(EventRSVP::class);
    }

    public function confirmedRsvps()
    {
        return $this->hasMany(EventRSVP::class)->where('status', 'confirmed');
    }

    public function attendedRsvps()
    {
        return $this->hasMany(EventRSVP::class)->where('status', 'attended');
    }

    public function documentation()
    {
        return $this->hasMany(EventDocumentation::class)->orderBy('sort_order');
    }

    public function photos()
    {
        return $this->hasMany(EventDocumentation::class)->where('type', 'photo')->orderBy('sort_order');
    }

    public function videos()
    {
        return $this->hasMany(EventDocumentation::class)->where('type', 'video')->orderBy('sort_order');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_datetime', '>', now())->where('status', 'published');
    }

    public function scopePast($query)
    {
        return $query->where('end_datetime', '<', now());
    }

    public function scopeOnline($query)
    {
        return $query->where('type', 'online');
    }

    public function scopeOffline($query)
    {
        return $query->where('type', 'offline');
    }

    // Helper Methods
    public function isUpcoming()
    {
        return $this->start_datetime > now();
    }

    public function isPast()
    {
        return $this->end_datetime < now();
    }

    public function isOngoing()
    {
        return $this->start_datetime <= now() && $this->end_datetime >= now();
    }

    public function isFull()
    {
        if (!$this->max_participants) {
            return false;
        }
        return $this->confirmedRsvps()->count() >= $this->max_participants;
    }

    public function availableSlots()
    {
        if (!$this->max_participants) {
            return null;
        }
        return max(0, $this->max_participants - $this->confirmedRsvps()->count());
    }

    public function getBannerUrlAttribute()
    {
        if ($this->banner_image && Storage::disk('public')->exists($this->banner_image)) {
            return Storage::url($this->banner_image);
        }
        return asset('assets/img/default-event-banner.jpg');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => '<span class="badge bg-secondary">Draft</span>',
            'published' => '<span class="badge bg-success">Published</span>',
            'cancelled' => '<span class="badge bg-danger">Cancelled</span>',
            'completed' => '<span class="badge bg-info">Completed</span>',
        ];
        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    public function getTypeBadgeAttribute()
    {
        $badges = [
            'offline' => '<span class="badge bg-primary">Offline</span>',
            'online' => '<span class="badge bg-info">Online</span>',
        ];
        return $badges[$this->type] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    public function getFormattedDateRangeAttribute()
    {
        if ($this->start_datetime->isSameDay($this->end_datetime)) {
            return $this->start_datetime->format('d M Y, H:i') . ' - ' . $this->end_datetime->format('H:i');
        }
        return $this->start_datetime->format('d M Y, H:i') . ' - ' . $this->end_datetime->format('d M Y, H:i');
    }
}
