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
        Schema::create('employee_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();

            $table->string('loan_number')->nullable();
            $table->string('description')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('installment_amount')->nullable();
            $table->enum('status', ['waiting approval', 'on going', 'paid', 'rejected'])->default(null)->nullable();

            // approved by, declined by
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('declined_by')->nullable();
            // reason
            $table->string('reason')->nullable();

            // created_by, updated_by, deleted_by
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_loans');
    }
};
