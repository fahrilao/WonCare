<?php

namespace App\Models;

use App\Notifications\MemberVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Member extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'language',
        'is_active',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Scope to get only active members
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get members by provider
     */
    public function scopeByProvider($query, $provider)
    {
        if ($provider === 'google') {
            return $query->whereNotNull('google_id');
        }
        
        return $query->whereNull('google_id');
    }

    /**
     * Check if member registered via Google
     */
    public function isGoogleUser()
    {
        return !is_null($this->google_id);
    }

    /**
     * Get member's full name with fallback
     */
    public function getDisplayNameAttribute()
    {
        return $this->name ?: 'Member #' . $this->id;
    }

    /**
     * Get member's avatar with fallback
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            // If it's a Google avatar URL, return as is
            if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                return $this->avatar;
            }
            // If it's a local file, return storage URL
            return asset('storage/avatars/' . $this->avatar);
        }
        
        // Default avatar based on name
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->display_name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get member's age
     */
    public function getAgeAttribute()
    {
        if (!$this->date_of_birth) {
            return null;
        }
        
        return $this->date_of_birth->age;
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin()
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new MemberVerifyEmail);
    }
}
