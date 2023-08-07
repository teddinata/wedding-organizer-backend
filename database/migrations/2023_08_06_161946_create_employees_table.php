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
            // department id
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            // position id
            $table->foreignId('position_id')->constrained('positions')->onDelete('cascade');

            $table->string('photo')->nullable();
            $table->string('nik');
            $table->string('fullname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('otp')->nullable();
            $table->timestamp('otp_verified_at')->nullable();
            $table->string('reset_token')->nullable();
            $table->string('notification_token')->nullable();
            $table->date('dateofbirth');
            $table->enum('gender', [1, 2]);
            $table->string('ktp_img')->nullable();
            $table->string('vaccine_img')->nullable();
            $table->decimal('salary', 10, 2);
            $table->decimal('loan_limit', 10, 2);
            $table->decimal('active_loan_limit', 10, 2);
            $table->foreignId('level_id')->constrained('levels')->onDelete('cascade');
            $table->integer('points')->default(0);
            $table->boolean('is_active')->default(true);

            // created by
            $table->unsignedBigInteger('created_by')->nullable();
            // updated by
            $table->unsignedBigInteger('updated_by')->nullable();
            // deleted by
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->timestamps();
            // soft delete
            $table->softDeletes();

            // index
            $table->index('nik');
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
