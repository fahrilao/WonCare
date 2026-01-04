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
   * Store Step 2: Financial Data (Income with deductions)
   */
  public function storeStep2(Request $request)
  {
    $request->validate([
      'gross_salary' => 'required|numeric|min:0',
      'kookmin_yeongeum' => 'nullable|numeric|min:0',
      'twejigeum' => 'nullable|numeric|min:0',
      'insurance' => 'nullable|numeric|min:0',
      'tax' => 'nullable|numeric|min:0',
      'other_deductions' => 'nullable|numeric|min:0',
    ]);

    $member = Auth::guard('member')->user();

    // Calculate net salary
    $totalDeductions = ($request->kookmin_yeongeum ?? 0) +
      ($request->twejigeum ?? 0) +
      ($request->insurance ?? 0) +
      ($request->tax ?? 0) +
      ($request->other_deductions ?? 0);
    $netSalary = $request->gross_salary - $totalDeductions;

    // Update member's monthly income
    $member->update([
      'monthly_income' => $netSalary,
    ]);

    // Create initial financial income record
    $member->financialIncomes()->create([
      'gross_salary' => $request->gross_salary,
      'kookmin_yeongeum' => $request->kookmin_yeongeum ?? 0,
      'twejigeum' => $request->twejigeum ?? 0,
      'insurance' => $request->insurance ?? 0,
      'tax' => $request->tax ?? 0,
      'other_deductions' => $request->other_deductions ?? 0,
      'net_salary' => $netSalary,
      'income_date' => now(),
      'notes' => 'Initial income from onboarding',
    ]);

    return redirect()->route('onboarding.step3');
  }

  /**
   * Step 3: Expenses
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
   * Store Step 3: Expenses by category
   */
  public function storeStep3(Request $request)
  {
    $request->validate([
      'rent' => 'nullable|numeric|min:0',
      'food' => 'nullable|numeric|min:0',
      'remittance' => 'nullable|numeric|min:0',
      'transport' => 'nullable|numeric|min:0',
      'entertainment' => 'nullable|numeric|min:0',
      'charity' => 'nullable|numeric|min:0',
      'other' => 'nullable|numeric|min:0',
    ]);

    $member = Auth::guard('member')->user();

    // Calculate total monthly expense
    $totalExpense = ($request->rent ?? 0) +
      ($request->food ?? 0) +
      ($request->remittance ?? 0) +
      ($request->transport ?? 0) +
      ($request->entertainment ?? 0) +
      ($request->charity ?? 0) +
      ($request->other ?? 0);

    // Update member's monthly expense
    $member->update([
      'monthly_expense' => $totalExpense,
    ]);

    // Create expense records for each category with amount
    $categories = ['rent', 'food', 'remittance', 'transport', 'entertainment', 'charity', 'other'];
    foreach ($categories as $category) {
      if ($request->$category && $request->$category > 0) {
        $member->financialExpenses()->create([
          'category' => $category,
          'amount' => $request->$category,
          'expense_date' => now(),
          'description' => 'Initial ' . $category . ' expense from onboarding',
          'notes' => 'Onboarding data',
        ]);
      }
    }

    return redirect()->route('onboarding.step4');
  }

  /**
   * Step 4: Occupation, Savings & Dream Assets
   */
  public function step4()
  {
    $member = Auth::guard('member')->user();

    if ($member->onboarding_completed) {
      return redirect()->route('dashboard');
    }

    if (!$member->monthly_expense) {
      return redirect()->route('onboarding.step3');
    }

    return view('member.onboarding.step4', compact('member'));
  }

  /**
   * Store Step 4: Occupation, Savings Target & Dream Assets
   */
  public function storeStep4(Request $request)
  {
    $request->validate([
      'occupation' => 'required|string|max:255',
      'financial_goal' => 'required|string|max:1000',
      'savings_target_amount' => 'nullable|numeric|min:0',
      'dream_assets' => 'nullable|array',
      'dream_assets.*.name' => 'required_with:dream_assets|string|max:255',
      'dream_assets.*.cost' => 'required_with:dream_assets|numeric|min:0',
      'dream_assets.*.priority' => 'required_with:dream_assets|integer|in:1,2,3',
    ]);

    $member = Auth::guard('member')->user();
    $member->update([
      'occupation' => $request->occupation,
      'financial_goal' => $request->financial_goal,
    ]);

    // Create savings target for current year if provided
    if ($request->savings_target_amount && $request->savings_target_amount > 0) {
      $member->savingsTargets()->create([
        'target_year' => date('Y'),
        'target_amount' => $request->savings_target_amount,
        'current_amount' => 0,
        'description' => 'Savings target from onboarding',
      ]);
    }

    // Create dream assets if provided
    if ($request->dream_assets && is_array($request->dream_assets)) {
      foreach ($request->dream_assets as $asset) {
        if (!empty($asset['name']) && !empty($asset['cost'])) {
          $member->dreamAssets()->create([
            'asset_name' => $asset['name'],
            'estimated_cost' => $asset['cost'],
            'priority' => $asset['priority'] ?? 2,
            'description' => 'Dream asset from onboarding',
          ]);
        }
      }
    }

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
