<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Priority order: Session > User preference > Default (en)
        $locale = session('locale', 'en');

        // Check if user is authenticated and has language preference
        if (auth()->check() && auth()->user()->language) {
            $locale = auth()->user()->language;
        }

        // Validate locale
        if (in_array($locale, ['en', 'id', 'ko'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
