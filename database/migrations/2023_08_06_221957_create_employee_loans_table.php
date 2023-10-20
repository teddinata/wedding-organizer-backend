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
            $table->string('loan_number')->nullable();
            $table->date('loan_date')->nullable();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('description')->nullable();
            $table->integer('loan_amount')->nullable();
            $table->enum('repayment_term', [1, 2])->nullable()->comment('Status: 1 = weekly, 2 = monthly');
            $table->integer('installment_amount')->nullable();
            // approved by, declined by
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->unsignedBigInteger('declined_by')->nullable();
            $table->dateTime('declined_at')->nullable();
            // reason
            $table->string('reason')->nullable();
            $table->enum('loan_status', ['waiting approval', 'approved', 'rejected'])->default('waiting approval')->nullable();
            $table->enum('repayment_status', ['none', 'ongoing', 'paid', 'canceled'])->default('none')->nullable();
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
