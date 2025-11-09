<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MemberAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('member')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('auth.login')->with('error', __('members.login_required'));
        }

        // Check if member is active
        $member = Auth::guard('member')->user();
        if (!$member->is_active) {
            Auth::guard('member')->logout();
            return redirect()->route('auth.login')->with('error', __('members.account_deactivated'));
        }

        return $next($request);
    }
}
