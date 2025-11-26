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
    // Point conversion settings table
    Schema::create('point_conversion_settings', function (Blueprint $table) {
      $table->id();
      $table->string('currency', 3); // IDR, KRW, etc.
      $table->decimal('amount_per_point', 15, 2); // How much currency = 1 point
      $table->boolean('is_active')->default(true);
      $table->text('description')->nullable();
      $table->timestamps();

      $table->unique('currency');
      $table->index('is_active');
    });

    // Member points table
    Schema::create('member_points', function (Blueprint $table) {
      $table->id();
      $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
      $table->integer('points')->default(0); // Current point balance
      $table->integer('total_earned')->default(0); // Total points earned (lifetime)
      $table->integer('total_spent')->default(0); // Total points spent (lifetime)
      $table->timestamps();

      $table->unique('member_id');
      $table->index(['member_id', 'points']);
    });

    // Point transactions table (history)
    Schema::create('point_transactions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
      $table->enum('type', ['earn', 'spend', 'adjustment']); // Transaction type
      $table->integer('points'); // Positive for earn, negative for spend
      $table->integer('balance_after'); // Point balance after transaction
      $table->string('source'); // donation, zakat, course_purchase, admin_adjustment, etc.
      $table->foreignId('source_id')->nullable(); // ID of donation/zakat/course
      $table->string('source_type')->nullable(); // Model class name
      $table->decimal('source_amount', 15, 2)->nullable(); // Original payment amount
      $table->string('source_currency', 3)->nullable(); // Currency of payment
      $table->text('description')->nullable();
      $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete(); // Admin who made adjustment
      $table->timestamps();

      $table->index(['member_id', 'created_at']);
      $table->index(['type', 'source']);
      $table->index('created_at');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('point_transactions');
    Schema::dropIfExists('member_points');
    Schema::dropIfExists('point_conversion_settings');
  }
};
