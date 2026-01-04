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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['offline', 'online'])->default('offline');
            $table->string('location')->nullable(); // For offline events
            $table->string('meeting_link')->nullable(); // For online events (Zoom, etc.)
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->integer('max_participants')->nullable();
            $table->enum('status', ['draft', 'published', 'cancelled', 'completed'])->default('draft');
            $table->string('banner_image')->nullable();
            $table->boolean('require_rsvp')->default(true);
            $table->boolean('send_reminder')->default(true);
            $table->integer('reminder_hours_before')->default(24); // Hours before event to send reminder
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['start_datetime', 'status']);
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
