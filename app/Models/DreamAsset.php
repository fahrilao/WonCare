<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DreamAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'asset_name',
        'estimated_cost',
        'priority',
        'target_date',
        'description',
        'is_achieved',
        'achieved_at',
    ];

    protected $casts = [
        'estimated_cost' => 'decimal:2',
        'target_date' => 'date',
        'is_achieved' => 'boolean',
        'achieved_at' => 'date',
    ];

    // Relationships
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Helper Methods
    public function markAsAchieved()
    {
        $this->is_achieved = true;
        $this->achieved_at = now();
        $this->save();
    }

    public function getPriorityBadgeAttribute()
    {
        $badges = [
            1 => '<span class="badge bg-danger">High Priority</span>',
            2 => '<span class="badge bg-warning">Medium Priority</span>',
            3 => '<span class="badge bg-info">Low Priority</span>',
        ];
        return $badges[$this->priority] ?? '<span class="badge bg-secondary">No Priority</span>';
    }

    // Scopes
    public function scopeForMember($query, $memberId)
    {
        return $query->where('member_id', $memberId);
    }

    public function scopeByPriority($query)
    {
        return $query->orderBy('priority', 'asc');
    }

    public function scopeAchieved($query)
    {
        return $query->where('is_achieved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_achieved', false);
    }
}
