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
    Schema::table('classes', function (Blueprint $table) {
      $table->integer('required_points')->default(0)->after('status');
      $table->index('required_points');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('classes', function (Blueprint $table) {
      $table->dropIndex(['required_points']);
      $table->dropColumn('required_points');
    });
  }
};
