<?php

namespace Database\Seeders;

use App\Models\CurrencySetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySettingSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $currencies = [
            [
                'currency_code' => 'IDR',
                'currency_name' => 'Indonesian Rupiah',
                'currency_symbol' => 'Rp',
                'exchange_rate_to_idr' => 1.0000, // Base currency
                'is_active' => true,
                'is_base_currency' => true,
                'description' => 'Indonesian Rupiah - Base currency for all conversions',
            ],
            [
                'currency_code' => 'KRW',
                'currency_name' => 'Korean Won',
                'currency_symbol' => '₩',
                'exchange_rate_to_idr' => 12.0000, // 1 KRW = 12 IDR (example rate)
                'is_active' => true,
                'is_base_currency' => false,
                'description' => 'Korean Won - Used for Korean payment gateway (Toss Payments)',
            ],
        ];

        foreach ($currencies as $currency) {
            CurrencySetting::updateOrCreate(
                ['currency_code' => $currency['currency_code']],
                $currency
            );
        }
    }
}
