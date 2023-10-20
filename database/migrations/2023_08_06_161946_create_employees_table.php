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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('employee_number');
            $table->string('fullname');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->foreignId('position_id')->constrained('positions')->onDelete('cascade');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('otp')->nullable();
            $table->timestamp('otp_verified_at')->nullable();
            $table->string('reset_token')->nullable();
            $table->string('notification_token')->nullable();
            $table->date('dateofbirth')->nullable();
            $table->enum('gender', [1, 2])->nullable()->comment('1 = Female, 2 = Male');
            $table->string('ktp_img')->nullable();
            $table->string('vaccine_img')->nullable();
            $table->integer('salary')->nullable();
            $table->integer('loan_limit')->nullable();
            $table->integer('active_loan_limit')->nullable();
            $table->foreignId('level_id')->constrained('employee_levels')->onDelete('cascade');
            $table->integer('points')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // index
            $table->index('employee_number');
            $table->index('fullname');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
