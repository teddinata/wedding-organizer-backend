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
        Schema::rename('levels', 'employee_levels');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // If needed, you can define a reverse operation here
        Schema::rename('employee_levels', 'levels');
    }
};
