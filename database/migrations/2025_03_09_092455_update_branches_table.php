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
        Schema::table('branches', function (Blueprint $table) {
            $table->integer('number_of_courts')->default(1); // Number of courts
            $table->string('stadium_map')->nullable(); // Single image upload
            $table->json('images')->nullable(); // Multiple images upload
        });
    }
};
