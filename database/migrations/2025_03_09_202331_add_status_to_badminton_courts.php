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
        Schema::table('badminton_courts', function (Blueprint $table) {
            $table->unsignedTinyInteger('status')->default(1)->comment('1: Open, 2: Close');
        });
    }
};
