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
        Schema::create('activity_section', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')
            ->nullable()
            ->references('id')
            ->on('activities')
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
        Schema::dropIfExists('activity_section');
    }
};
