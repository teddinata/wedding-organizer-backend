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
        Schema::table('departments', function (Blueprint $table) {
            // payroll type 1 = monthly, 2 = weekly use enum
            $table->enum('payroll_type', [1, 2])->default(1)->after('name');
            $table->boolean('is_has_schedule')->default(false)->after('payroll_type');
            $table->time('clock_in')->nullable()->after('is_has_schedule');
            $table->time('clock_out')->nullable()->after('clock_in');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            // payroll type 1 = monthly, 2 = weekly use enum
            $table->dropColumn('payroll_type');
            $table->dropColumn('is_has_schedule');
            $table->dropColumn('clock_in');
            $table->dropColumn('clock_out');
        });
    }
};
