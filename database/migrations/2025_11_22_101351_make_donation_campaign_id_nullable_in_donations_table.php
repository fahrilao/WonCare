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
            // Drop the foreign key constraint first
            $table->dropForeign(['donation_campaign_id']);

            // Modify the column to be nullable
            $table->foreignId('donation_campaign_id')->nullable()->change();

            // Re-add the foreign key constraint with nullable
            $table->foreign('donation_campaign_id')
                ->references('id')
                ->on('donation_campaigns')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            //
        });
    }
};
