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
        $member = Auth::guard('member')->user();

        if ($member->hasVerifiedEmail()) {
            // Check if onboarding is completed
            if (!$member->onboarding_completed) {
                return redirect()->route('onboarding.step1');
            }
            return redirect()->intended(route('dashboard'));
        }

        return view('member.auth.verify-email');
    }

    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verify()
    {
        $member = Auth::guard('member')->user();

        if ($member->hasVerifiedEmail()) {
            // Check if onboarding is completed
            if (!$member->onboarding_completed) {
                return redirect()->route('onboarding.step1');
            }
            return redirect()->intended(route('dashboard') . '?verified=1');
        }

        if ($member->markEmailAsVerified()) {
            event(new Verified($member));
        }

        // After verification, check if onboarding is completed
        if (!$member->onboarding_completed) {
            return redirect()->route('onboarding.step1');
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
            // Check if onboarding is completed
            if (!$member->onboarding_completed) {
                return redirect()->route('onboarding.step1');
            }
            return redirect()->intended(route('dashboard'));
        }

        $member->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
