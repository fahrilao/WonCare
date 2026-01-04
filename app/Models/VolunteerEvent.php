<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerEvent extends Model
{
  protected $fillable = [
    'title',
    'description',
    'start_at',
    'end_at',
    'region',
    'location',
    'is_online',
    'registration_link',
    'is_active',
  ];

  protected $casts = [
    'start_at' => 'datetime',
    'end_at' => 'datetime',
    'is_online' => 'boolean',
    'is_active' => 'boolean',
  ];
}
