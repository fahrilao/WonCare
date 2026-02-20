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
        $member = Auth::guard('member')->user();

        // Support both single-category (modal) and per-category (onboarding-style) submission
        if ($request->has('category') && $request->has('amount')) {
            // Single category mode (modal form)
            $validated = $request->validate([
                'category' => 'required|in:rent,food,remittance,transport,entertainment,charity,other',
                'amount' => 'required|numeric|min:0',
                'expense_date' => 'required|date',
                'description' => 'nullable|string|max:255',
                'notes' => 'nullable|string',
            ]);
            $validated['member_id'] = $member->id;
            FinancialExpense::create($validated);
        } else {
            // Per-category mode (onboarding-style: fields named rent, food, etc.)
            $categories = array_keys(FinancialExpense::getCategories());
            $request->validate([
                'expense_date' => 'nullable|date',
            ]);
            $expenseDate = $request->input('expense_date', date('Y-m-d'));
            foreach ($categories as $cat) {
                $amount = (float) $request->input($cat, 0);
                if ($amount > 0) {
                    FinancialExpense::create([
                        'member_id' => $member->id,
                        'category' => $cat,
                        'amount' => $amount,
                        'expense_date' => $expenseDate,
                    ]);
                }
            }
        }

        return redirect()->route('member.financial-tools.index')
            ->with('success', __('financial.expense_added'));
    }

    public function storeSavingsTarget(Request $request)
    {
        $validated = $request->validate([
            'target_year' => 'required|integer|min:2024',
            'target_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $member = Auth::guard('member')->user();
        $validated['member_id'] = $member->id;

        // Auto-compute current_amount from actual net income for the target year
        $yearlyIncome = FinancialIncome::forMember($member->id)
            ->inYear($validated['target_year'])
            ->sum('net_salary');
        $yearlyExpenses = FinancialExpense::forMember($member->id)
            ->inYear($validated['target_year'])
            ->sum('amount');
        $validated['current_amount'] = max(0, $yearlyIncome - $yearlyExpenses);

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
            'priority' => 'required|integer|min:1|max:3',
            'target_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $member = Auth::guard('member')->user();
        $validated['member_id'] = $member->id;

        DreamAsset::create($validated);

        return redirect()->route('member.financial-tools.index')
            ->with('success', __('financial.dream_asset_added'));
    }

    public function incomeDetail(Request $request)
    {
        $member = Auth::guard('member')->user();
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', '');

        $query = FinancialIncome::forMember($member->id)
            ->whereYear('income_date', $year)
            ->orderBy('income_date', 'desc');

        if ($month) {
            $query->whereMonth('income_date', $month);
        }

        $incomes = $query->get();

        $totalGross = $incomes->sum('gross_salary');
        $totalDeductions = $incomes->sum(
            fn($i) =>
            $i->kookmin_yeongeum + $i->twejigeum + $i->insurance + $i->tax + $i->other_deductions
        );
        $totalNet = $incomes->sum('net_salary');

        $availableYears = FinancialIncome::forMember($member->id)
            ->selectRaw('YEAR(income_date) as year')
            ->groupBy('year')
            ->orderByDesc('year')
            ->pluck('year');

        return view('member.financial-tools.income-detail', compact(
            'incomes',
            'totalGross',
            'totalDeductions',
            'totalNet',
            'year',
            'month',
            'availableYears'
        ));
    }

    public function expenseDetail(Request $request)
    {
        $member = Auth::guard('member')->user();
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', '');
        $category = $request->input('category', '');

        $query = FinancialExpense::forMember($member->id)
            ->whereYear('expense_date', $year)
            ->orderBy('expense_date', 'desc');

        if ($month) {
            $query->whereMonth('expense_date', $month);
        }
        if ($category) {
            $query->where('category', $category);
        }

        $expenses = $query->get();

        $totalExpenses = $expenses->sum('amount');

        $byCategory = FinancialExpense::forMember($member->id)
            ->whereYear('expense_date', $year)
            ->when($month, fn($q) => $q->whereMonth('expense_date', $month))
            ->selectRaw('category, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $availableYears = FinancialExpense::forMember($member->id)
            ->selectRaw('YEAR(expense_date) as year')
            ->groupBy('year')
            ->orderByDesc('year')
            ->pluck('year');

        $categories = FinancialExpense::getCategories();

        return view('member.financial-tools.expense-detail', compact(
            'expenses',
            'totalExpenses',
            'byCategory',
            'year',
            'month',
            'category',
            'availableYears',
            'categories'
        ));
    }

    public function savingsDetail(Request $request)
    {
        $member = Auth::guard('member')->user();

        $allTargets = SavingsTarget::forMember($member->id)
            ->orderByDesc('target_year')
            ->get();

        $selectedYear = $request->input('year', date('Y'));

        $monthlyData = collect(range(1, 12))->map(function ($m) use ($member, $selectedYear) {
            $income  = FinancialIncome::forMember($member->id)->inMonth($selectedYear, $m)->sum('net_salary');
            $expense = FinancialExpense::forMember($member->id)->inMonth($selectedYear, $m)->sum('amount');
            return [
                'month'   => $m,
                'income'  => (float) $income,
                'expense' => (float) $expense,
                'savings' => max(0, (float) $income - (float) $expense),
            ];
        });

        $yearlyIncome  = FinancialIncome::forMember($member->id)->whereYear('income_date', $selectedYear)->sum('net_salary');
        $yearlyExpense = FinancialExpense::forMember($member->id)->whereYear('expense_date', $selectedYear)->sum('amount');
        $yearlySavings = max(0, $yearlyIncome - $yearlyExpense);

        $savingsTarget = SavingsTarget::forMember($member->id)->forYear($selectedYear)->first();

        $availableYears = FinancialIncome::forMember($member->id)
            ->selectRaw('YEAR(income_date) as year')
            ->groupBy('year')
            ->orderByDesc('year')
            ->pluck('year');

        if ($availableYears->isEmpty()) {
            $availableYears = collect([date('Y')]);
        }

        return view('member.financial-tools.savings-detail', compact(
            'allTargets',
            'selectedYear',
            'monthlyData',
            'yearlyIncome',
            'yearlyExpense',
            'yearlySavings',
            'savingsTarget',
            'availableYears'
        ));
    }

    public function monthlyChartData(Request $request)
    {
        $member = Auth::guard('member')->user();
        $year = $request->input('year', date('Y'));

        $months = collect(range(1, 12))->map(function ($m) use ($member, $year) {
            $income = FinancialIncome::forMember($member->id)
                ->inMonth($year, $m)->sum('net_salary');
            $expense = FinancialExpense::forMember($member->id)
                ->inMonth($year, $m)->sum('amount');
            return [
                'month' => $m,
                'income' => (float) $income,
                'expense' => (float) $expense,
                'savings' => max(0, (float) $income - (float) $expense),
            ];
        });

        return response()->json(['year' => $year, 'data' => $months]);
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

        $netSavings = $income - $expenses;
        // Clamp rates: expenses can exceed income (negative savings)
        $savingsRate = ($netSavings / $income) * 100;
        $expenseRate = min(($expenses / $income) * 100, 100);

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
            'savings' => $netSavings,
            'savings_rate' => round($savingsRate, 2),
            'expense_rate' => round($expenseRate, 2),
        ];

        return $recommendations;
    }

    private function calculateZakat($memberId)
    {
        // Accumulated net savings across all recorded years (approximates hawl wealth)
        $totalIncome = FinancialIncome::forMember($memberId)->sum('net_salary');
        $totalExpenses = FinancialExpense::forMember($memberId)->sum('amount');
        $netWealth = max(0, $totalIncome - $totalExpenses);

        // Nisab = 85g gold. ZakatSetting uses key-value pairs.
        $nisabThreshold = 85000000; // IDR fallback (~85g gold)
        try {
            $goldPriceSetting = \App\Models\ZakatSetting::where('key', 'gold_price_per_gram')
                ->where('is_active', true)->first();
            $goldNisabSetting = \App\Models\ZakatSetting::where('key', 'gold_nisab_grams')
                ->where('is_active', true)->first();
            if ($goldPriceSetting && $goldNisabSetting && $goldPriceSetting->value > 0) {
                $nisabThreshold = $goldNisabSetting->value * $goldPriceSetting->value;
            }
        } catch (\Exception $e) {
            // ZakatSetting not available, use fallback
        }

        $zakatAmount = 0;
        $isEligible = false;

        if ($netWealth >= $nisabThreshold) {
            $isEligible = true;
            $zakatAmount = $netWealth * 0.025; // 2.5% zakat mal rate
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
