<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('community_posts', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->longText('content');
      $table->string('author_name')->nullable();
      $table->string('status')->default('published')->index();
      $table->boolean('is_pinned')->default(false)->index();
      $table->timestamp('published_at')->nullable()->index();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('community_posts');
  }
};
