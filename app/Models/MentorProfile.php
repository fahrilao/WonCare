<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorProfile extends Model
{
  protected $fillable = [
    'name',
    'title',
    'bio',
    'expertise',
    'photo_path',
    'is_active',
    'sort_order',
  ];

  protected $casts = [
    'is_active' => 'boolean',
    'sort_order' => 'integer',
  ];
}
