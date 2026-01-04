<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('volunteer_registrations', function (Blueprint $table) {
      $table->id();
      $table->string('full_name');
      $table->string('phone')->nullable();
      $table->string('email')->nullable();
      $table->string('region')->nullable()->index();
      $table->string('type')->default('digital')->index();
      $table->text('skills')->nullable();
      $table->text('availability')->nullable();
      $table->string('status')->default('new')->index();
      $table->text('notes')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('volunteer_registrations');
  }
};
