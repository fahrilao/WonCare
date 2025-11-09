<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class EnsureMemberEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user('member') ||
            ($request->user('member') instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&
            ! $request->user('member')->hasVerifiedEmail())) {
            return $request->expectsJson()
                    ? abort(409, 'Your email address is not verified.')
                    : Redirect::guest(URL::route('auth.verification.notice'));
        }

        return $next($request);
    }
}
