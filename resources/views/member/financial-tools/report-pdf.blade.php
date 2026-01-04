<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ __('financial.report.title') }} - {{ $year }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            color: #4CAF50;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table th {
            background-color: #f5f5f5;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
            font-weight: bold;
        }

        table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .summary-box {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }

        .summary-item:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 14px;
        }

        .label {
            font-weight: bold;
        }

        .amount {
            text-align: right;
        }

        .positive {
            color: #4CAF50;
        }

        .negative {
            color: #f44336;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ __('financial.report.title') }}</h1>
        <p>{{ $member->name }}</p>
        <p>{{ __('financial.report.year') }}: {{ $year }}</p>
        <p>{{ __('financial.report.generated_at') }}: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Summary Section -->
    <div class="section">
        <div class="section-title">{{ __('financial.dashboard') }}</div>
        <div class="summary-box">
            <div class="summary-item">
                <span class="label">{{ __('financial.report.total_income') }}:</span>
                <span class="amount positive">Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
            </div>
            <div class="summary-item">
                <span class="label">{{ __('financial.report.total_expenses') }}:</span>
                <span class="amount negative">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</span>
            </div>
            <div class="summary-item">
                <span class="label">{{ __('financial.report.net_savings') }}:</span>
                <span class="amount {{ $totalIncome - $totalExpenses >= 0 ? 'positive' : 'negative' }}">
                    Rp {{ number_format($totalIncome - $totalExpenses, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Income Details -->
    <div class="section">
        <div class="section-title">{{ __('financial.income') }}</div>
        @if ($incomes->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>{{ __('financial.date') }}</th>
                        <th>{{ __('financial.gross_salary') }}</th>
                        <th>{{ __('financial.total_deductions') }}</th>
                        <th>{{ __('financial.net_salary') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($incomes as $income)
                        <tr>
                            <td>{{ $income->income_date->format('d/m/Y') }}</td>
                            <td>Rp {{ number_format($income->gross_salary, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($income->total_deductions, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($income->net_salary, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>{{ __('financial.no_data') }}</p>
        @endif
    </div>

    <!-- Expense Details -->
    <div class="section">
        <div class="section-title">{{ __('financial.expenses') }}</div>
        @if ($expenses->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>{{ __('financial.date') }}</th>
                        <th>{{ __('financial.expense_category') }}</th>
                        <th>{{ __('financial.expense_description') }}</th>
                        <th>{{ __('financial.amount') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenses as $expense)
                        <tr>
                            <td>{{ $expense->expense_date->format('d/m/Y') }}</td>
                            <td>{{ __('financial.expense_categories.' . $expense->category) }}</td>
                            <td>{{ $expense->description ?? '-' }}</td>
                            <td>Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Expense Breakdown by Category -->
            <h4>{{ __('financial.expense_breakdown') }}</h4>
            <table>
                <thead>
                    <tr>
                        <th>{{ __('financial.expense_category') }}</th>
                        <th>{{ __('financial.amount') }}</th>
                        <th>%</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expensesByCategory as $categoryExpense)
                        <tr>
                            <td>{{ __('financial.expense_categories.' . $categoryExpense->category) }}</td>
                            <td>Rp {{ number_format($categoryExpense->total, 0, ',', '.') }}</td>
                            <td>{{ number_format(($categoryExpense->total / $totalExpenses) * 100, 1) }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>{{ __('financial.no_data') }}</p>
        @endif
    </div>

    <div class="page-break"></div>

    <!-- Savings Targets -->
    <div class="section">
        <div class="section-title">{{ __('financial.savings_targets') }}</div>
        @if ($savingsTargets->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>{{ __('financial.target_year') }}</th>
                        <th>{{ __('financial.target_amount') }}</th>
                        <th>{{ __('financial.current_amount') }}</th>
                        <th>{{ __('financial.progress') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($savingsTargets as $target)
                        <tr>
                            <td>{{ $target->target_year }}</td>
                            <td>Rp {{ number_format($target->target_amount, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($target->current_amount, 0, ',', '.') }}</td>
                            <td>{{ $target->progress_percentage }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>{{ __('financial.no_data') }}</p>
        @endif
    </div>

    <!-- Dream Assets -->
    <div class="section">
        <div class="section-title">{{ __('financial.dream_assets') }}</div>
        @if ($dreamAssets->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>{{ __('financial.asset_name') }}</th>
                        <th>{{ __('financial.estimated_cost') }}</th>
                        <th>{{ __('financial.priority') }}</th>
                        <th>{{ __('financial.target_date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dreamAssets as $asset)
                        <tr>
                            <td>{{ $asset->asset_name }}</td>
                            <td>Rp {{ number_format($asset->estimated_cost, 0, ',', '.') }}</td>
                            <td>{{ __('financial.priority_levels.' . $asset->priority) }}</td>
                            <td>{{ $asset->target_date ? $asset->target_date->format('d/m/Y') : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>{{ __('financial.no_data') }}</p>
        @endif
    </div>

    <!-- Zakat Information -->
    @if (isset($zakatInfo))
        <div class="section">
            <div class="section-title">{{ __('financial.zakat.title') }}</div>
            <div class="summary-box">
                <div class="summary-item">
                    <span class="label">{{ __('financial.zakat.net_wealth') }}:</span>
                    <span class="amount">Rp {{ number_format($zakatInfo['net_wealth'], 0, ',', '.') }}</span>
                </div>
                <div class="summary-item">
                    <span class="label">{{ __('financial.zakat.nisab_threshold') }}:</span>
                    <span class="amount">Rp {{ number_format($zakatInfo['nisab_threshold'], 0, ',', '.') }}</span>
                </div>
                @if ($zakatInfo['is_eligible'])
                    <div class="summary-item">
                        <span class="label">{{ __('financial.zakat.zakat_amount') }}:</span>
                        <span class="amount positive">Rp
                            {{ number_format($zakatInfo['zakat_amount'], 0, ',', '.') }}</span>
                    </div>
                    <p style="color: #4CAF50; font-weight: bold;">{{ __('financial.zakat.eligible') }}</p>
                @else
                    <p style="color: #666;">{{ __('financial.zakat.not_eligible') }}</p>
                @endif
            </div>
        </div>
    @endif

    <div class="footer">
        <p>{{ config('app.name') }} - {{ __('financial.report.title') }}</p>
        <p>{{ __('financial.report.generated_at') }}: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>
