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
    Schema::table('donations', function (Blueprint $table) {
      // Add currency field (IDR for Rupiah, KRW for Won)
      // Other fields already exist from previous migrations
      $table->string('currency', 3)->default('IDR')->after('amount');

      // Add index for better query performance
      $table->index(['currency', 'status']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('donations', function (Blueprint $table) {
      $table->dropIndex(['currency', 'status']);
      $table->dropColumn('currency');
    });
  }
};
