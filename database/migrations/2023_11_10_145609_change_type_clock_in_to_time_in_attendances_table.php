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
        Schema::table('attendances', function (Blueprint $table) {
            // change type clock_in to time
            $table->time('clock_in')->change()->nullable();
            $table->time('clock_out')->change()->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // change type clock_in to time
            $table->dateTime('clock_in')->change()->nullable();
            $table->dateTime('clock_out')->change()->nullable();
        });
    }
};
