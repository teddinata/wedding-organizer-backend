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
        Schema::table('order_additional_services', function (Blueprint $table) {
            // change additional_service_id set to nullable
            $table->unsignedBigInteger('additional_service_id')->nullable()->change();
            $table->string('name')->nullable()->after('employee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_additional_services', function (Blueprint $table) {
            // drop

            $table->dropSoftDeletes();
            $table->dropColumn('name');
        });
    }
};
