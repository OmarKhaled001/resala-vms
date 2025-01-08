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
        Schema::create('section_contribution', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contribution_id')
            ->nullable()
            ->references('id')
            ->on('contributions')
            ->cascadeOnDelete();
            $table->foreignId('section_id')
            ->nullable()
            ->references('id')
            ->on('sections')
            ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_contribution');
    }
};
