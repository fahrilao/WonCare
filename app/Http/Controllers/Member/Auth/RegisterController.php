<?php

namespace App\Http\Controllers\Member\Auth;

use App\Events\MemberRegistered;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the member registration form
     */
    public function showRegistrationForm()
    {
        return view('member.auth.register');
    }

    /**
     * Handle member registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members',
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'language' => 'nullable|in:en,id,ko',
        ]);

        // Create the member
        $member = Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'language' => $request->language ?? 'en',
            'is_active' => true,
        ]);

        // Fire the member registered event
        event(new MemberRegistered($member));

        // Log the registration
        logger()->info('New member registered', [
            'member_id' => $member->id,
            'email' => $member->email,
            'ip' => $request->ip(),
        ]);

        // Auto-login the member
        Auth::guard('member')->login($member);

        // Update last login
        $member->updateLastLogin();

        // Set locale
        Session::put('locale', $member->language);

        // Send email verification notification
        $member->sendEmailVerificationNotification();

        // Redirect to email verification notice
        return redirect()->route('auth.verification.notice')
            ->with('success', __('Registration successful! Please check your email to verify your account.'));
    }
}
