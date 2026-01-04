<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->boolean('onboarding_completed')->default(false)->after('is_active');
            $table->decimal('monthly_income', 15, 2)->nullable()->after('onboarding_completed');
            $table->decimal('monthly_expense', 15, 2)->nullable()->after('monthly_income');
            $table->string('occupation')->nullable()->after('monthly_expense');
            $table->text('financial_goal')->nullable()->after('occupation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['onboarding_completed', 'monthly_income', 'monthly_expense', 'occupation', 'financial_goal']);
        });
    }
};
