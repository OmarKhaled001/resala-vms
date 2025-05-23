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
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                ->nullable()
                ->references('id')
                ->on('branches')
                ->cascadeOnDelete();
            $table->foreignId('section_id')
                ->nullable()
                ->references('id')
                ->on('sections')
                ->cascadeOnDelete();
            $table->foreignId('activity_id')
                ->nullable()
                ->references('id')
                ->on('activities')
                ->onDelete('set null');
            $table->string('name');
            $table->string('username')->nullable()->unique();
            $table->string('position')->nullable();
            $table->string('national')->nullable();
            $table->string('phone');
            $table->string('gender');
            $table->date('birth_date')->nullable();
            $table->date('vol_date')->nullable();
            $table->string('address')->nullable();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('tshirt')->default(0);
            $table->boolean('mine_camp')->default(0);
            $table->boolean('camp_48')->default(0);
            $table->boolean('is_active')->default(0);
            $table->boolean('is_admin')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};
