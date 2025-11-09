<?php

namespace App\Http\Controllers\Member\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:member');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Display the email verification notice.
     */
    public function notice()
    {
        return Auth::guard('member')->user()->hasVerifiedEmail()
            ? redirect()->intended(route('dashboard'))
            : view('member.auth.verify-email');
    }

    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verify()
    {
        $member = Auth::guard('member')->user();

        if ($member->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard') . '?verified=1');
        }

        if ($member->markEmailAsVerified()) {
            event(new Verified($member));
        }

        return redirect()->intended(route('dashboard') . '?verified=1');
    }

    /**
     * Send a new verification email.
     */
    public function resend()
    {
        $member = Auth::guard('member')->user();

        if ($member->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }

        $member->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
