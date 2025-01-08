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
            $table->date('event_date')->nullable();
            $table->foreignId('contribution_id')->nullable()->references('id')->on('contributions')->onDelete('set null');
            $table->foreignId('branch_id')->nullable()->references('id')->on('branches')->onDelete('set null');
            $table->foreignId('section_id')->nullable()->references('id')->on('sections')->onDelete('set null');
            $table->foreignId('activity_id')->nullable()->references('id')->on('activities')->onDelete('set null');
            $table->enum('status', ['conforming', 'non-conforming', 'rejected' , 'pending']);
            $table->text('notes')->nullable();
            $table->text('reason')->nullable();
            $table->timestamps();
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
