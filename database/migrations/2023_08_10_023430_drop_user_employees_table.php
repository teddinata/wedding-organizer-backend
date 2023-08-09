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
        // drop table
        Schema::dropIfExists('user_employees');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
