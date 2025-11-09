<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the member profile
     */
    public function show()
    {
        $member = Auth::guard('member')->user();

        return view('member.profile.show', compact('member'));
    }

    /**
     * Show the profile edit form
     */
    public function edit()
    {
        $member = Auth::guard('member')->user();

        return view('member.profile.edit', compact('member'));
    }

    /**
     * Update the member profile
     */
    public function update(Request $request)
    {
        $member = Auth::guard('member')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members,email,' . $member->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
        ]);

        $data = $request->only([
            'name',
            'email',
            'phone',
            'date_of_birth',
            'gender',
            'address',
        ]);

        $member->update($data);

        logger()->info('Member profile updated', [
            'member_id' => $member->id,
            'email' => $member->email,
            'ip' => $request->ip(),
        ]);

        return redirect()->route('profile.show')
            ->with('success', __('members.profile_updated'));
    }

    /**
     * Show change password form
     */
    public function showChangePasswordForm()
    {
        $member = Auth::guard('member')->user();

        // Google-only users cannot change password
        if ($member->isGoogleUser() && !$member->password) {
            return redirect()->route('profile.show')
                ->with('error', __('members.google_only_no_password'));
        }

        return view('member.profile.change-password', compact('member'));
    }

    /**
     * Update member password
     */
    public function updatePassword(Request $request)
    {
        $member = Auth::guard('member')->user();

        // Google-only users cannot change password
        if ($member->isGoogleUser() && !$member->password) {
            return redirect()->route('profile.show')
                ->with('error', __('members.google_only_no_password'));
        }

        $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, $member->password)) {
            return back()->withErrors([
                'current_password' => __('members.current_password_incorrect'),
            ]);
        }

        $member->update([
            'password' => Hash::make($request->password),
        ]);

        logger()->info('Member password changed', [
            'member_id' => $member->id,
            'email' => $member->email,
            'ip' => $request->ip(),
        ]);

        return redirect()->route('profile.show')
            ->with('success', __('members.password_updated'));
    }
}
