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
        Schema::create('donation_campaign_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_campaign_id')->constrained()->onDelete('cascade');
            $table->foreignId('donation_tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['donation_campaign_id', 'donation_tag_id'], 'campaign_tag_unique');
            $table->index('donation_campaign_id');
            $table->index('donation_tag_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_campaign_tag');
    }
};
