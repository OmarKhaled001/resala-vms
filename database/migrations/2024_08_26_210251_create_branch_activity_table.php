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
        Schema::create('branch_activity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->nullable()
            ->references('id')
            ->on('activities')
            ->onDelete('set null');
            $table->foreignId('branch_id')->nullable()
            ->references('id')
            ->on('branches')
            ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_activity');
    }
};
