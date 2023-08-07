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
        Schema::create('order_additional_services', function (Blueprint $table) {
            $table->id();
            // order id
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            // additional service id
            $table->foreignId('additional_service_id')->constrained('additional_requests')->cascadeOnDelete();
            // employee id
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();

            $table->integer('salary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_additional_services');
    }
};
