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
      // Remove redundant status field
      // We only use payment_status now
      $table->dropColumn('status');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('donations', function (Blueprint $table) {
      // Restore status field if needed
      $table->string('status')->default('pending')->after('amount');
    });
  }
};
