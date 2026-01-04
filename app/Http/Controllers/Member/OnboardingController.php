<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
  public function __construct()
  {
    $this->middleware('member.auth');
  }

  /**
   * Step 1: Welcome & App Description
   */
  public function step1()
  {
    $member = Auth::guard('member')->user();

    if ($member->onboarding_completed) {
      return redirect()->route('dashboard');
    }

    // Check if email is verified
    if (!$member->hasVerifiedEmail()) {
      return redirect()->route('auth.verification.notice');
    }

    return view('member.onboarding.step1', compact('member'));
  }

  /**
   * Store Step 1: Just continue to next step
   */
  public function storeStep1(Request $request)
  {
    $member = Auth::guard('member')->user();

    // Check email verification
    if (!$member->hasVerifiedEmail()) {
      return redirect()->route('onboarding.step1')
        ->with('error', __('onboarding.email_not_verified'));
    }

    return redirect()->route('onboarding.step2');
  }

  /**
   * Step 2: Financial Data (Income & Expense)
   */
  public function step2()
  {
    $member = Auth::guard('member')->user();

    if ($member->onboarding_completed) {
      return redirect()->route('dashboard');
    }

    if (!$member->hasVerifiedEmail()) {
      return redirect()->route('onboarding.step1');
    }

    return view('member.onboarding.step2', compact('member'));
  }

  /**
   * Store Step 2: Financial Data
   */
  public function storeStep2(Request $request)
  {
    $request->validate([
      'monthly_income' => 'required|numeric|min:0',
      'monthly_expense' => 'required|numeric|min:0',
    ]);

    $member = Auth::guard('member')->user();
    $member->update([
      'monthly_income' => $request->monthly_income,
      'monthly_expense' => $request->monthly_expense,
    ]);

    return redirect()->route('onboarding.step3');
  }

  /**
   * Step 3: Occupation
   */
  public function step3()
  {
    $member = Auth::guard('member')->user();

    if ($member->onboarding_completed) {
      return redirect()->route('dashboard');
    }

    if (!$member->monthly_income) {
      return redirect()->route('onboarding.step2');
    }

    return view('member.onboarding.step3', compact('member'));
  }

  /**
   * Store Step 3: Occupation
   */
  public function storeStep3(Request $request)
  {
    $request->validate([
      'occupation' => 'required|string|max:255',
    ]);

    $member = Auth::guard('member')->user();
    $member->update([
      'occupation' => $request->occupation,
    ]);

    return redirect()->route('onboarding.step4');
  }

  /**
   * Step 4: Financial Goal
   */
  public function step4()
  {
    $member = Auth::guard('member')->user();

    if ($member->onboarding_completed) {
      return redirect()->route('dashboard');
    }

    if (!$member->occupation) {
      return redirect()->route('onboarding.step3');
    }

    return view('member.onboarding.step4', compact('member'));
  }

  /**
   * Store Step 4: Financial Goal
   */
  public function storeStep4(Request $request)
  {
    $request->validate([
      'financial_goal' => 'required|string|max:1000',
    ]);

    $member = Auth::guard('member')->user();
    $member->update([
      'financial_goal' => $request->financial_goal,
    ]);

    return redirect()->route('onboarding.step5');
  }

  /**
   * Step 5: Welcome Message & Complete
   */
  public function step5()
  {
    $member = Auth::guard('member')->user();

    if ($member->onboarding_completed) {
      return redirect()->route('dashboard');
    }

    if (!$member->financial_goal) {
      return redirect()->route('onboarding.step4');
    }

    return view('member.onboarding.step5', compact('member'));
  }

  /**
   * Complete Onboarding
   */
  public function complete()
  {
    $member = Auth::guard('member')->user();
    $member->update([
      'onboarding_completed' => true,
    ]);

    return redirect()->route('dashboard')
      ->with('success', __('onboarding.completed_success'));
  }
}
