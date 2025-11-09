<?php

namespace App\Http\Controllers\Member\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if member already exists with this Google ID
            $member = Member::where('google_id', $googleUser->getId())->first();

            if ($member) {
                // Existing Google user - login
                if (!$member->is_active) {
                    return redirect()->route('login')
                        ->with('error', __('members.account_deactivated'));
                }

                Auth::guard('member')->login($member);
                $member->updateLastLogin();

                // Update avatar if changed
                if ($member->avatar !== $googleUser->getAvatar()) {
                    $member->update(['avatar' => $googleUser->getAvatar()]);
                }

                Session::put('locale', $member->language);

                logger()->info('Member logged in via Google', [
                    'member_id' => $member->id,
                    'email' => $member->email,
                    'ip' => $request->ip(),
                ]);

                return redirect()->route('dashboard')
                    ->with('success', __('members.welcome_back', ['name' => $member->name]));
            }

            // Check if email already exists (regular account)
            $existingMember = Member::where('email', $googleUser->getEmail())->first();

            if ($existingMember) {
                // Link Google account to existing member
                $existingMember->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);

                Auth::guard('member')->login($existingMember);
                $existingMember->updateLastLogin();
                Session::put('locale', $existingMember->language);

                logger()->info('Google account linked to existing member', [
                    'member_id' => $existingMember->id,
                    'email' => $existingMember->email,
                    'ip' => $request->ip(),
                ]);

                return redirect()->route('dashboard')
                    ->with('success', __('members.google_linked'));
            }

            // Create new member from Google
            $member = Member::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => now(), // Google accounts are pre-verified
                'language' => 'en',
                'is_active' => true,
            ]);

            Auth::guard('member')->login($member);
            $member->updateLastLogin();
            Session::put('locale', $member->language);

            logger()->info('New member registered via Google', [
                'member_id' => $member->id,
                'email' => $member->email,
                'ip' => $request->ip(),
            ]);

            return redirect()->route('dashboard')
                ->with('success', __('members.google_registration_success', ['name' => $member->name]));
        } catch (\Exception $e) {
            logger()->error('Google OAuth error', [
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);

            return redirect()->route('login')
                ->with('error', __('members.google_auth_failed'));
        }
    }
}
