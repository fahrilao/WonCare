<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ZakatSetting;
use Illuminate\Http\Request;

class ZakatSettingController extends Controller
{
    public function index()
    {
        $settings = ZakatSetting::orderBy('category')->orderBy('key')->get();
        return view('admin.zakat-settings.index', compact('settings'));
    }

    public function edit(ZakatSetting $zakatSetting)
    {
        return view('admin.zakat-settings.edit', compact('zakatSetting'));
    }

    public function update(Request $request, ZakatSetting $zakatSetting)
    {
        $validated = $request->validate([
            'value' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $zakatSetting->update([
            'value' => $validated['value'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.zakat-settings.index')
            ->with('success', __('zakat.setting_updated'));
    }
}
