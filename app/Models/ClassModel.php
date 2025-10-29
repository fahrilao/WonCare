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
}
