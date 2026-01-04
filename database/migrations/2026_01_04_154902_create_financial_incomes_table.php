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
        Schema::create('financial_incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->decimal('gross_salary', 15, 2); // Gaji kotor
            $table->decimal('kookmin_yeongeum', 15, 2)->default(0); // Korean National Pension
            $table->decimal('twejigeum', 15, 2)->default(0); // Retirement fund
            $table->decimal('insurance', 15, 2)->default(0); // Asuransi
            $table->decimal('tax', 15, 2)->default(0); // Pajak
            $table->decimal('other_deductions', 15, 2)->default(0); // Potongan lainnya
            $table->decimal('net_salary', 15, 2); // Gaji bersih (calculated)
            $table->date('income_date'); // Tanggal gaji
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['member_id', 'income_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_incomes');
    }
};
