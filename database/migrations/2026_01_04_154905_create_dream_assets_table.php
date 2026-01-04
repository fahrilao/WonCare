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
        Schema::create('dream_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->string('asset_name');
            $table->decimal('estimated_cost', 15, 2);
            $table->integer('priority')->default(0); // 1=highest, lower number = higher priority
            $table->date('target_date')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_achieved')->default(false);
            $table->date('achieved_at')->nullable();
            $table->timestamps();

            $table->index(['member_id', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dream_assets');
    }
};
