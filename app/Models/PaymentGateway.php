<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class PaymentGateway extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'provider',
        'api_key',
        'secret_key',
        'webhook_secret',
        'additional_config',
        'is_active',
        'is_sandbox',
        'description',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'additional_config' => 'array',
        'is_active' => 'boolean',
        'is_sandbox' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'api_key',
        'secret_key',
        'webhook_secret',
    ];

    /**
     * Available payment gateway providers.
     */
    const PROVIDERS = [
        'midtrans' => 'Midtrans',
        'stripe' => 'Stripe',
        'toss' => 'Toss Payments',
    ];

    /**
     * Get the creator of the payment gateway.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Encrypt and set the API key.
     */
    public function setApiKeyAttribute($value): void
    {
        $this->attributes['api_key'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Decrypt and get the API key.
     */
    public function getApiKeyAttribute($value): ?string
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    /**
     * Encrypt and set the secret key.
     */
    public function setSecretKeyAttribute($value): void
    {
        $this->attributes['secret_key'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Decrypt and get the secret key.
     */
    public function getSecretKeyAttribute($value): ?string
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    /**
     * Encrypt and set the webhook secret.
     */
    public function setWebhookSecretAttribute($value): void
    {
        $this->attributes['webhook_secret'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Decrypt and get the webhook secret.
     */
    public function getWebhookSecretAttribute($value): ?string
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    /**
     * Get the provider name.
     */
    public function getProviderNameAttribute(): string
    {
        return self::PROVIDERS[$this->provider] ?? $this->provider;
    }

    /**
     * Get the status badge HTML.
     */
    public function getStatusBadgeAttribute(): string
    {
        $class = $this->is_active ? 'bg-success' : 'bg-secondary';
        $text = $this->is_active ? __('common.active') : __('common.inactive');
        
        return '<span class="badge ' . $class . '">' . $text . '</span>';
    }

    /**
     * Get the mode badge HTML.
     */
    public function getModeBadgeAttribute(): string
    {
        $class = $this->is_sandbox ? 'bg-warning' : 'bg-primary';
        $text = $this->is_sandbox ? __('payment_gateways.sandbox') : __('payment_gateways.production');
        
        return '<span class="badge ' . $class . '">' . $text . '</span>';
    }

    /**
     * Scope to get only active gateways.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get gateways by provider.
     */
    public function scopeByProvider($query, $provider)
    {
        return $query->where('provider', $provider);
    }

    /**
     * Check if the gateway is configured (has required keys).
     */
    public function isConfigured(): bool
    {
        return !empty($this->api_key) || !empty($this->secret_key);
    }

    /**
     * Get masked API key for display.
     */
    public function getMaskedApiKey(): string
    {
        if (!$this->api_key) {
            return __('payment_gateways.not_set');
        }
        
        $key = $this->api_key;
        if (strlen($key) <= 8) {
            return str_repeat('*', strlen($key));
        }
        
        return substr($key, 0, 4) . str_repeat('*', strlen($key) - 8) . substr($key, -4);
    }

    /**
     * Get masked secret key for display.
     */
    public function getMaskedSecretKey(): string
    {
        if (!$this->secret_key) {
            return __('payment_gateways.not_set');
        }
        
        $key = $this->secret_key;
        if (strlen($key) <= 8) {
            return str_repeat('*', strlen($key));
        }
        
        return substr($key, 0, 4) . str_repeat('*', strlen($key) - 8) . substr($key, -4);
    }
}
