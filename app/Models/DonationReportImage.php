<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class DonationReportImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_report_id',
        'image_url',
        'alt_text',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the donation report that owns the image.
     */
    public function donationReport(): BelongsTo
    {
        return $this->belongsTo(DonationReport::class);
    }

    /**
     * Get the full URL for the image.
     */
    public function getImageUrlAttribute($value): string
    {
        if (!$value) {
            return '';
        }

        // If it's already a full URL, return as is
        if (str_starts_with($value, 'http')) {
            return $value;
        }

        // Return the storage URL
        return Storage::url($value);
    }

    /**
     * Delete the image file from storage when the model is deleted.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($image) {
            if ($image->image_url && Storage::exists($image->image_url)) {
                Storage::delete($image->image_url);
            }
        });
    }
}
