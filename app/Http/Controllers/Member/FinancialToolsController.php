<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\FinancialIncome;
use App\Models\FinancialExpense;
use App\Models\SavingsTarget;
use App\Models\DreamAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class FinancialToolsController extends Controller
{
    public function index()
    {
        $member = Auth::guard('member')->user();
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Get current month data
        $monthlyIncome = FinancialIncome::forMember($member->id)
            ->inMonth($currentYear, $currentMonth)
            ->sum('net_salary');

        $monthlyExpenses = FinancialExpense::forMember($member->id)
            ->inMonth($currentYear, $currentMonth)
            ->sum('amount');

        // Get expense breakdown by category
        $expensesByCategory = FinancialExpense::forMember($member->id)
            ->inMonth($currentYear, $currentMonth)
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();

        // Get savings target for current year
        $savingsTarget = SavingsTarget::forMember($member->id)
            ->forYear($currentYear)
            ->first();

        // Get dream assets
        $dreamAssets = DreamAsset::forMember($member->id)
            ->pending()
            ->byPriority()
            ->get();

        // Calculate budget recommendations
        $recommendations = $this->calculateRecommendations($monthlyIncome, $monthlyExpenses);

        // Calculate zakat eligibility
        $zakatInfo = $this->calculateZakat($member->id);

        return view('member.financial-tools.index', compact(
            'monthlyIncome',
            'monthlyExpenses',
            'expensesByCategory',
            'savingsTarget',
            'dreamAssets',
            'recommendations',
            'zakatInfo'
        ));
    }

    public function storeIncome(Request $request)
    {
        $validated = $request->validate([
            'gross_salary' => 'required|numeric|min:0',
            'kookmin_yeongeum' => 'nullable|numeric|min:0',
            'twejigeum' => 'nullable|numeric|min:0',
            'insurance' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'other_deductions' => 'nullable|numeric|min:0',
            'income_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $member = Auth::guard('member')->user();
        $validated['member_id'] = $member->id;

        // Calculate net salary
        $totalDeductions = ($validated['kookmin_yeongeum'] ?? 0) +
            ($validated['twejigeum'] ?? 0) +
            ($validated['insurance'] ?? 0) +
            ($validated['tax'] ?? 0) +
            ($validated['other_deductions'] ?? 0);
        $validated['net_salary'] = $validated['gross_salary'] - $totalDeductions;

        FinancialIncome::create($validated);

        return redirect()->route('member.financial-tools.index')
            ->with('success', __('financial.income_added'));
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|in:rent,food,remittance,transport,entertainment,charity,other',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $member = Auth::guard('member')->user();
        $validated['member_id'] = $member->id;

        FinancialExpense::create($validated);

        return redirect()->route('member.financial-tools.index')
            ->with('success', __('financial.expense_added'));
    }

    public function storeSavingsTarget(Request $request)
    {
        $validated = $request->validate([
            'target_year' => 'required|integer|min:2024',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $member = Auth::guard('member')->user();
        $validated['member_id'] = $member->id;
        $validated['current_amount'] = $validated['current_amount'] ?? 0;

        SavingsTarget::updateOrCreate(
            ['member_id' => $member->id, 'target_year' => $validated['target_year']],
            $validated
        );

        return redirect()->route('member.financial-tools.index')
            ->with('success', __('financial.savings_target_saved'));
    }

    public function storeDreamAsset(Request $request)
    {
        $validated = $request->validate([
            'asset_name' => 'required|string|max:255',
            'estimated_cost' => 'required|numeric|min:0',
            'priority' => 'required|integer|min:1|max:10',
            'target_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $member = Auth::guard('member')->user();
        $validated['member_id'] = $member->id;

        DreamAsset::create($validated);

        return redirect()->route('member.financial-tools.index')
            ->with('success', __('financial.dream_asset_added'));
    }

    public function calculateZakatAuto()
    {
        $member = Auth::guard('member')->user();
        $zakatInfo = $this->calculateZakat($member->id);

        return response()->json($zakatInfo);
    }

    public function downloadReport()
    {
        $member = Auth::guard('member')->user();
        $currentYear = date('Y');

        // Get all financial data
        $incomes = FinancialIncome::forMember($member->id)
            ->inYear($currentYear)
            ->orderBy('income_date', 'desc')
            ->get();

        $expenses = FinancialExpense::forMember($member->id)
            ->inYear($currentYear)
            ->orderBy('expense_date', 'desc')
            ->get();

        $savingsTargets = SavingsTarget::forMember($member->id)
            ->forYear($currentYear)
            ->get();

        $dreamAssets = DreamAsset::forMember($member->id)
            ->byPriority()
            ->get();

        // Calculate totals
        $totalIncome = $incomes->sum('net_salary');
        $totalExpenses = $expenses->sum('amount');
        $netSavings = $totalIncome - $totalExpenses;

        $expensesByCategory = $expenses->groupBy('category')->map(function ($items) {
            return $items->sum('amount');
        });

        $pdf = Pdf::loadView('member.financial-tools.report-pdf', compact(
            'member',
            'currentYear',
            'incomes',
            'expenses',
            'savingsTargets',
            'dreamAssets',
            'totalIncome',
            'totalExpenses',
            'netSavings',
            'expensesByCategory'
        ));

        return $pdf->download('financial-report-' . $currentYear . '.pdf');
    }

    private function calculateRecommendations($income, $expenses)
    {
        if ($income <= 0) {
            return [
                'status' => 'no_data',
                'message' => __('financial.recommendations.no_income_data'),
            ];
        }

        $savingsRate = (($income - $expenses) / $income) * 100;
        $expenseRate = ($expenses / $income) * 100;

        // 50/30/20 rule: 50% needs, 30% wants, 20% savings
        $recommendations = [];

        if ($savingsRate >= 20) {
            $recommendations['savings'] = [
                'status' => 'good',
                'message' => __('financial.recommendations.savings_good'),
            ];
        } elseif ($savingsRate >= 10) {
            $recommendations['savings'] = [
                'status' => 'fair',
                'message' => __('financial.recommendations.savings_fair'),
            ];
        } else {
            $recommendations['savings'] = [
                'status' => 'poor',
                'message' => __('financial.recommendations.savings_poor'),
            ];
        }

        if ($expenseRate <= 80) {
            $recommendations['expenses'] = [
                'status' => 'good',
                'message' => __('financial.recommendations.expenses_good'),
            ];
        } else {
            $recommendations['expenses'] = [
                'status' => 'high',
                'message' => __('financial.recommendations.expenses_high'),
            ];
        }

        $recommendations['summary'] = [
            'income' => $income,
            'expenses' => $expenses,
            'savings' => $income - $expenses,
            'savings_rate' => round($savingsRate, 2),
            'expense_rate' => round($expenseRate, 2),
        ];

        return $recommendations;
    }

    private function calculateZakat($memberId)
    {
        $currentYear = date('Y');

        // Get total income for the year
        $totalIncome = FinancialIncome::forMember($memberId)
            ->inYear($currentYear)
            ->sum('net_salary');

        // Get total expenses
        $totalExpenses = FinancialExpense::forMember($memberId)
            ->inYear($currentYear)
            ->sum('amount');

        // Net wealth
        $netWealth = $totalIncome - $totalExpenses;

        // Nisab threshold (approximately 85 grams of gold, ~IDR 85,000,000 or ~KRW 7,000,000)
        // This should be configurable based on current gold prices
        $nisabThreshold = 85000000; // IDR

        $zakatAmount = 0;
        $isEligible = false;

        if ($netWealth >= $nisabThreshold) {
            $isEligible = true;
            $zakatAmount = $netWealth * 0.025; // 2.5% of net wealth
        }

        return [
            'is_eligible' => $isEligible,
            'net_wealth' => $netWealth,
            'nisab_threshold' => $nisabThreshold,
            'zakat_amount' => $zakatAmount,
            'remaining_to_nisab' => max(0, $nisabThreshold - $netWealth),
        ];
    }
}
