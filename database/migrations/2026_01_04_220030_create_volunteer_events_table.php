<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('volunteer_events', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->longText('description')->nullable();
      $table->timestamp('start_at')->nullable()->index();
      $table->timestamp('end_at')->nullable()->index();
      $table->string('region')->nullable()->index();
      $table->string('location')->nullable();
      $table->boolean('is_online')->default(false)->index();
      $table->string('registration_link')->nullable();
      $table->boolean('is_active')->default(true)->index();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('volunteer_events');
  }
};
