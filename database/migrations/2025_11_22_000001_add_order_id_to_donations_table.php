<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('donations', function (Blueprint $table) {
      $table->string('order_id')->nullable()->unique()->after('id');
      $table->string('payment_status')->nullable()->after('status');
      $table->text('payment_response')->nullable()->after('snap_redirect_url');
    });
  }

  public function down(): void
  {
    Schema::table('donations', function (Blueprint $table) {
      $table->dropColumn(['order_id', 'payment_status', 'payment_response']);
    });
  }
};
