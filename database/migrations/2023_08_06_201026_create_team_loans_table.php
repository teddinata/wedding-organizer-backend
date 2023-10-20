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
        Schema::create('team_loans', function (Blueprint $table) {
            $table->id();
            $table->string('loan_number')->nullable();
            $table->date('loan_date')->nullable();
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->integer('loan_amount')->nullable();
            $table->enum('loan_status', ['waiting approval', 'approved', 'rejected'])->default(null)->nullable();
            $table->enum('repayment_status', ['none', 'ongoing', 'paid', 'canceled'])->default('none')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_loans');
    }
};
