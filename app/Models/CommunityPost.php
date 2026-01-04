<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
  protected $fillable = [
    'title',
    'content',
    'author_name',
    'status',
    'is_pinned',
    'published_at',
  ];

  protected $casts = [
    'is_pinned' => 'boolean',
    'published_at' => 'datetime',
  ];
}
