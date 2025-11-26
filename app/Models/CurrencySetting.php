<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_code',
        'currency_name',
        'currency_symbol',
        'exchange_rate_to_idr',
        'is_active',
        'is_base_currency',
        'description',
    ];

    protected $casts = [
        'exchange_rate_to_idr' => 'decimal:4',
        'is_active' => 'boolean',
        'is_base_currency' => 'boolean',
    ];

    /**
     * Scope to get only active currencies
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the base currency (IDR)
     */
    public static function getBaseCurrency()
    {
        return static::where('is_base_currency', true)->first();
    }

    /**
     * Get currency by code
     */
    public static function getByCurrencyCode(string $code)
    {
        return static::where('currency_code', $code)->first();
    }

    /**
     * Convert amount from this currency to IDR
     */
    public function convertToIDR(float $amount): float
    {
        return $amount * $this->exchange_rate_to_idr;
    }

    /**
     * Convert amount from IDR to this currency
     */
    public function convertFromIDR(float $amount): float
    {
        if ($this->exchange_rate_to_idr == 0) {
            return 0;
        }
        return $amount / $this->exchange_rate_to_idr;
    }

    /**
     * Convert between two currencies
     */
    public static function convert(float $amount, string $fromCurrency, string $toCurrency): float
    {
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        $from = static::getByCurrencyCode($fromCurrency);
        $to = static::getByCurrencyCode($toCurrency);

        if (!$from || !$to) {
            return $amount;
        }

        // Convert to IDR first, then to target currency
        $amountInIDR = $from->convertToIDR($amount);
        return $to->convertFromIDR($amountInIDR);
    }

    /**
     * Format amount with currency symbol
     */
    public function formatAmount(float $amount): string
    {
        return $this->currency_symbol . ' ' . number_format($amount, 0, ',', '.');
    }
}
