<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CurrencySetting;
use Illuminate\Http\Request;

class CurrencySettingController extends Controller
{
    public function index()
    {
        $currencies = CurrencySetting::orderBy('is_base_currency', 'desc')
            ->orderBy('currency_code')
            ->get();

        return view('admin.currency-settings.index', compact('currencies'));
    }

    public function edit(CurrencySetting $currencySetting)
    {
        return view('admin.currency-settings.edit', compact('currencySetting'));
    }

    public function update(Request $request, CurrencySetting $currencySetting)
    {
        $validated = $request->validate([
            'currency_name' => ['required', 'string', 'max:255'],
            'currency_symbol' => ['required', 'string', 'max:10'],
            'exchange_rate_to_idr' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
            'description' => ['nullable', 'string'],
        ]);

        // Prevent changing base currency exchange rate
        if ($currencySetting->is_base_currency) {
            $validated['exchange_rate_to_idr'] = 1.0000;
        }

        $currencySetting->update([
            'currency_name' => $validated['currency_name'],
            'currency_symbol' => $validated['currency_symbol'],
            'exchange_rate_to_idr' => $validated['exchange_rate_to_idr'],
            'is_active' => $request->has('is_active'),
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.currency-settings.index')
            ->with('success', 'Currency setting updated successfully');
    }
}
