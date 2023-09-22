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
        Schema::table('team_leads', function (Blueprint $table) {
            // add employee_id column
            $table->unsignedBigInteger('employee_id')->constrained('employees')->onDelete('cascade')->after('team_id');
            // change user_id column to nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_leads', function (Blueprint $table) {
            // drop employee_id column if exists
            $table->dropColumnIfExists('employee_id');
            // change user_id column to not nullable
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};
