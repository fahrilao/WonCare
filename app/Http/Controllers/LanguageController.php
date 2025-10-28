<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $locale)
    {
        if (!in_array($locale, ['en', 'id', 'ko'])) {
            abort(400);
        }

        // Store locale in session for persistence
        Session::put('locale', $locale);

        // Update user's language preference if authenticated
        if (auth()->check()) {
            User::where('id', auth()->user()->id)->update([
                'language' => $locale,
            ]);
        }

        return redirect()->back();
    }
}
