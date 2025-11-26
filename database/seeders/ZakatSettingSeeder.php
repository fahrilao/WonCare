<?php

namespace Database\Seeders;

use App\Models\ZakatSetting;
use Illuminate\Database\Seeder;

class ZakatSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'gold_price_per_gram',
                'label' => 'Gold Price per Gram',
                'value' => 1050000,
                'unit' => '₩/gram',
                'category' => 'gold',
                'description' => 'Current market price of gold per gram',
                'is_active' => true,
            ],
            [
                'key' => 'gold_nisab_grams',
                'label' => 'Gold Nisab',
                'value' => 85,
                'unit' => 'grams',
                'category' => 'gold',
                'description' => 'Minimum gold amount for Zakat obligation (85 grams)',
                'is_active' => true,
            ],
            [
                'key' => 'silver_price_per_gram',
                'label' => 'Silver Price per Gram',
                'value' => 15000,
                'unit' => '₩/gram',
                'category' => 'silver',
                'description' => 'Current market price of silver per gram',
                'is_active' => true,
            ],
            [
                'key' => 'silver_nisab_grams',
                'label' => 'Silver Nisab',
                'value' => 595,
                'unit' => 'grams',
                'category' => 'silver',
                'description' => 'Minimum silver amount for Zakat obligation (595 grams)',
                'is_active' => true,
            ],
            [
                'key' => 'rice_price_per_kg',
                'label' => 'Rice Price per Kg',
                'value' => 15000,
                'unit' => '₩/kg',
                'category' => 'rice',
                'description' => 'Current market price of rice per kilogram',
                'is_active' => true,
            ],
            [
                'key' => 'fitrah_amount_kg',
                'label' => 'Fitrah Amount',
                'value' => 2.5,
                'unit' => 'kg',
                'category' => 'rice',
                'description' => 'Amount of rice per person for Zakat Fitrah (2.5 kg or 3.5 liters)',
                'is_active' => true,
            ],
            [
                'key' => 'zakat_percentage',
                'label' => 'Zakat Percentage',
                'value' => 2.5,
                'unit' => '%',
                'category' => 'general',
                'description' => 'Standard Zakat rate (2.5%)',
                'is_active' => true,
            ],
        ];

        foreach ($settings as $setting) {
            ZakatSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
