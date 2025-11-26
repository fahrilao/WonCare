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
        Schema::create('currency_settings', function (Blueprint $table) {
            $table->id();
            $table->string('currency_code', 3)->unique(); // IDR, KRW, USD, etc.
            $table->string('currency_name'); // Indonesian Rupiah, Korean Won
            $table->string('currency_symbol', 10); // Rp, ₩, $
            $table->decimal('exchange_rate_to_idr', 15, 4)->default(1); // Rate to convert to IDR
            $table->boolean('is_active')->default(true);
            $table->boolean('is_base_currency')->default(false); // IDR is base
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['currency_code', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_settings');
    }
};
