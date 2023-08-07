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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            // employee id
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');

            $table->date('date')->nullable();
            $table->dateTime('clock_in')->nullable();
            $table->string('clock_in_photo')->nullable();
            $table->float('clock_in_location')->nullable();
            $table->string('clock_in_address')->nullable();
            $table->dateTime('clock_out')->nullable();
            $table->string('clock_out_photo')->nullable();
            $table->float('clock_out_location')->nullable();
            $table->string('clock_out_address')->nullable();
            // status enum 1: ontime, 2: late
            $table->enum('status', [1, 2])->nullable();
            $table->enum('platform', ['web', 'mobile'])->nullable();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
