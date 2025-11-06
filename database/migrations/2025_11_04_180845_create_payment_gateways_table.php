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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Gateway name (Midtrans, Stripe, Toss Payments)
            $table->string('provider'); // Provider identifier (midtrans, stripe, toss)
            $table->text('api_key')->nullable(); // Encrypted API key
            $table->text('secret_key')->nullable(); // Encrypted secret key
            $table->text('webhook_secret')->nullable(); // Encrypted webhook secret
            $table->json('additional_config')->nullable(); // Additional configuration as JSON
            $table->boolean('is_active')->default(false); // Gateway status
            $table->boolean('is_sandbox')->default(true); // Sandbox/Production mode
            $table->text('description')->nullable(); // Gateway description
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('provider');
            $table->index('is_active');
            $table->index('created_by');

            // Foreign key constraint
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
