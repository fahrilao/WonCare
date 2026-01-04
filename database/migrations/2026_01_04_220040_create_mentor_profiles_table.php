<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('mentor_profiles', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('title')->nullable();
      $table->longText('bio')->nullable();
      $table->text('expertise')->nullable();
      $table->string('photo_path')->nullable();
      $table->boolean('is_active')->default(true)->index();
      $table->unsignedInteger('sort_order')->default(0);
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('mentor_profiles');
  }
};
