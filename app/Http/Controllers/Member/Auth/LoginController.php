<?php

namespace App\Http\Controllers\Member\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the member login form
     */
    public function index()
    {
        return view('member.auth.login');
    }

    /**
     * Handle member login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // Check if member exists and is active
        $member = Member::where('email', $credentials['email'])->first();

        if (!$member) {
            throw ValidationException::withMessages([
                'email' => [__('members.invalid_credentials')],
            ]);
        }

        if (!$member->is_active) {
            throw ValidationException::withMessages([
                'email' => [__('members.account_deactivated')],
            ]);
        }

        // Check if member has password (not Google-only user)
        if (!$member->password) {
            throw ValidationException::withMessages([
                'email' => [__('members.google_only_account')],
            ]);
        }

        // Attempt authentication
        if (Auth::guard('member')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Update last login
            $member->updateLastLogin();

            // Set locale
            Session::put('locale', $member->language);

            // Log successful login
            logger()->info('Member logged in', [
                'member_id' => $member->id,
                'email' => $member->email,
                'ip' => $request->ip(),
            ]);

            return redirect()->intended(route('dashboard'))
                ->with('success', __('members.welcome_back', ['name' => $member->name]));
        }

        // Log failed login attempt
        logger()->warning('Failed member login attempt', [
            'email' => $credentials['email'],
            'ip' => $request->ip(),
        ]);

        throw ValidationException::withMessages([
            'email' => [__('members.invalid_credentials')],
        ]);
    }

    /**
     * Handle member logout
     */
    public function logout(Request $request)
    {
        $member = Auth::guard('member')->user();

        // Log logout
        if ($member) {
            logger()->info('Member logged out', [
                'member_id' => $member->id,
                'email' => $member->email,
                'ip' => $request->ip(),
            ]);
        }

        Auth::guard('member')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login')
            ->with('success', __('members.logout_success'));
    }
}
