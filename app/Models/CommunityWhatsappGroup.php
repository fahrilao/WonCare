<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityWhatsappGroup extends Model
{
  protected $fillable = [
    'region',
    'name',
    'whatsapp_link',
    'description',
    'is_active',
    'sort_order',
  ];

  protected $casts = [
    'is_active' => 'boolean',
    'sort_order' => 'integer',
  ];
}
