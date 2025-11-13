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
        Schema::create('donation_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_campaign_id')->constrained()->onDelete('cascade');
            $table->decimal('distributed_amount', 15, 2);
            $table->date('distribution_date');
            $table->text('description')->nullable();
            $table->text('beneficiaries')->nullable(); // Who received the donations
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending'); // pending, verified, rejected
            $table->string('evidence_file')->nullable(); // File path for evidence document
            $table->text('notes')->nullable(); // Admin notes
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            
            $table->index(['donation_campaign_id', 'status']);
            $table->index('distribution_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_reports');
    }
};
