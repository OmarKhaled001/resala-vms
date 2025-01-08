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
        Schema::create('volunteer_modifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->nullable()
            ->references('id')
            ->on('volunteers')
            ->onDelete('set null');
            $table->enum('process',['update','delete','resignation','return']);
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer_modifications');
    }
};
