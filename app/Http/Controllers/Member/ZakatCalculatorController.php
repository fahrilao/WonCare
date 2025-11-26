<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\ZakatSetting;
use App\Models\CurrencySetting;
use Illuminate\Http\Request;

class ZakatCalculatorController extends Controller
{
    public function index()
    {
        // Get all active zakat settings
        $settings = ZakatSetting::where('is_active', true)->get()->keyBy('key');

        // Get specific settings with defaults
        $goldPrice = $settings->get('gold_price_per_gram')?->value ?? 1050000;
        $silverPrice = $settings->get('silver_price_per_gram')?->value ?? 15000;
        $goldNisab = $settings->get('gold_nisab_grams')?->value ?? 85;
        $silverNisab = $settings->get('silver_nisab_grams')?->value ?? 595;
        $zakatPercentage = $settings->get('zakat_percentage')?->value ?? 2.5;
        $ricePrice = $settings->get('rice_price_per_kg')?->value ?? 15000;
        $fitrahAmount = $settings->get('fitrah_amount_kg')?->value ?? 2.5;

        // Get active currencies for selection
        $currencies = CurrencySetting::active()->get();

        return view('member.zakat.calculator', compact(
            'goldPrice',
            'silverPrice',
            'goldNisab',
            'silverNisab',
            'zakatPercentage',
            'ricePrice',
            'fitrahAmount',
            'currencies'
        ));
    }
}
