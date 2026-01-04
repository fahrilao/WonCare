<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialIncome extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'gross_salary',
        'kookmin_yeongeum',
        'twejigeum',
        'insurance',
        'tax',
        'other_deductions',
        'net_salary',
        'income_date',
        'notes',
    ];

    protected $casts = [
        'gross_salary' => 'decimal:2',
        'kookmin_yeongeum' => 'decimal:2',
        'twejigeum' => 'decimal:2',
        'insurance' => 'decimal:2',
        'tax' => 'decimal:2',
        'other_deductions' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'income_date' => 'date',
    ];

    // Relationships
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Helper Methods
    public function getTotalDeductionsAttribute()
    {
        return $this->kookmin_yeongeum + $this->twejigeum + $this->insurance + $this->tax + $this->other_deductions;
    }

    public function calculateNetSalary()
    {
        return $this->gross_salary - $this->total_deductions;
    }

    // Scopes
    public function scopeForMember($query, $memberId)
    {
        return $query->where('member_id', $memberId);
    }

    public function scopeInMonth($query, $year, $month)
    {
        return $query->whereYear('income_date', $year)
            ->whereMonth('income_date', $month);
    }

    public function scopeInYear($query, $year)
    {
        return $query->whereYear('income_date', $year);
    }
}
