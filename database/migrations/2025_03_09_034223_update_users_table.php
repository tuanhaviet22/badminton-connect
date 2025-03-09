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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->unsignedTinyInteger('skill_level')->default(1);
            $table->json('preferred_play_time')->nullable();
            $table->text('location')->nullable();
            $table->enum('role', ['player', 'court_manager'])->default('player');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'avatar',
                'bio',
                'skill_level',
                'preferred_play_time',
                'location',
                'role',
            ]);
        });
    }
};
