<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialExpense extends Model
{
    use HasFactory;

    const CATEGORY_RENT = 'rent';
    const CATEGORY_FOOD = 'food';
    const CATEGORY_REMITTANCE = 'remittance';
    const CATEGORY_TRANSPORT = 'transport';
    const CATEGORY_ENTERTAINMENT = 'entertainment';
    const CATEGORY_CHARITY = 'charity';
    const CATEGORY_OTHER = 'other';

    protected $fillable = [
        'member_id',
        'category',
        'amount',
        'expense_date',
        'description',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
    ];

    // Relationships
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Helper Methods
    public static function getCategories()
    {
        return [
            self::CATEGORY_RENT => 'financial.expense_categories.rent',
            self::CATEGORY_FOOD => 'financial.expense_categories.food',
            self::CATEGORY_REMITTANCE => 'financial.expense_categories.remittance',
            self::CATEGORY_TRANSPORT => 'financial.expense_categories.transport',
            self::CATEGORY_ENTERTAINMENT => 'financial.expense_categories.entertainment',
            self::CATEGORY_CHARITY => 'financial.expense_categories.charity',
            self::CATEGORY_OTHER => 'financial.expense_categories.other',
        ];
    }

    public function getCategoryLabelAttribute()
    {
        $categories = self::getCategories();
        return __($categories[$this->category] ?? $this->category);
    }

    // Scopes
    public function scopeForMember($query, $memberId)
    {
        return $query->where('member_id', $memberId);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeInMonth($query, $year, $month)
    {
        return $query->whereYear('expense_date', $year)
            ->whereMonth('expense_date', $month);
    }

    public function scopeInYear($query, $year)
    {
        return $query->whereYear('expense_date', $year);
    }
}
