<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DonationReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_campaign_id',
        'distributed_amount',
        'distribution_date',
        'description',
        'beneficiaries',
        'status',
        'evidence_file',
        'notes',
        'created_by',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'distributed_amount' => 'decimal:2',
        'distribution_date' => 'date',
        'verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($report) {
            if (auth()->check()) {
                $report->created_by = auth()->id();
            }
        });
    }

    // Relationships
    public function donationCampaign(): BelongsTo
    {
        return $this->belongsTo(DonationCampaign::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function images(): HasMany
    {
        return $this->hasMany(DonationReportImage::class)->orderBy('sort_order');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeForCampaign($query, $campaignId)
    {
        return $query->where('donation_campaign_id', $campaignId);
    }

    // Accessors & Mutators
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'verified' => '<span class="badge bg-success">Verified</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getFormattedDistributedAmountAttribute(): string
    {
        return number_format($this->distributed_amount, 0, ',', '.');
    }

    public function getFormattedDistributionDateAttribute(): string
    {
        return $this->distribution_date->format('M d, Y');
    }

    // Helper methods
    public function canBeEdited(): bool
    {
        return $this->status === 'pending';
    }

    public function canBeVerified(): bool
    {
        return $this->status === 'pending';
    }

    public function verify($verifierId = null): void
    {
        $this->update([
            'status' => 'verified',
            'verified_by' => $verifierId ?? auth()->id(),
            'verified_at' => now(),
        ]);
    }

    public function reject($verifierId = null): void
    {
        $this->update([
            'status' => 'rejected',
            'verified_by' => $verifierId ?? auth()->id(),
            'verified_at' => now(),
        ]);
    }
}
