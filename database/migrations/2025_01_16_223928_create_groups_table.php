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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
            ->nullable()
            ->references('id')
            ->on('branches')
            ->cascadeOnDelete();
            $table->foreignId('activity_id')
            ->nullable()
            ->references('id')
            ->on('activities')
            ->onDelete('set null');
            $table->enum('class', ['first', 'second', 'third' , 'fourth','graduate']);
            $table->string('category')->nullable();
            $table->boolean('is_active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
