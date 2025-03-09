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
        // Modify branches table to add new fields
        Schema::table('branches', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->json('amenities')->nullable();
            $table->json('opening_hours')->nullable();
            $table->decimal('price_per_hour', 10, 2)->nullable();
        });

        // Modify badminton_courts table
        Schema::table('badminton_courts', function (Blueprint $table) {
            $table->decimal('price_per_hour', 10, 2)->nullable()->change();
            $table->boolean('use_branch_price')->default(true); // If true, use branch price
            $table->dropColumn(['address', 'latitude', 'longitude', 'amenities', 'opening_hours']);
        });
    }
};
