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
        Schema::create('order_histories', function (Blueprint $table) {
            $table->id();
            // order id
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            // employee id
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();

            // status entum new, on going, checklist done, on the way, arrived, work started, work done, handover,completed
            $table->enum('status', ['new', 'on going', 'checklist done', 'on the way', 'arrived', 'work started', 'work done', 'handover', 'completed'])->default('new');
            $table->string('photo')->nullable();
            $table->integer('signed_by')->nullable();
            $table->string('signature')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_histories');
    }
};
