<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerRegistration extends Model
{
  protected $fillable = [
    'full_name',
    'phone',
    'email',
    'region',
    'type',
    'skills',
    'availability',
    'status',
    'notes',
  ];
}
