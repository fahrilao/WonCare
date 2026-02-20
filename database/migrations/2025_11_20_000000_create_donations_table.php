<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('donations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
      $table->foreignId('donation_campaign_id')->constrained('donation_campaigns')->onDelete('cascade');
      $table->decimal('amount', 15, 2);
      $table->string('status')->default('pending'); // pending, paid, failed, cancelled
      $table->text('note')->nullable();
      $table->string('snap_redirect_url')->nullable();
      $table->timestamps();

      $table->index(['member_id', 'donation_campaign_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('donations');
  }
};
