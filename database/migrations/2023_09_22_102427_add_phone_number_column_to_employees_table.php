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
        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable()->change();
            $table->foreignId('position_id')->nullable()->change();

            $table->string('phone_number')->nullable()->after('email');
            $table->string('nik')->nullable()->change();
            $table->string('fullname')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->date('dateofbirth')->nullable()->change();
            $table->enum('gender', [1, 2])->nullable()->change();
            $table->double('salary', 10, 2)->nullable()->change();
            $table->double('loan_limit', 10, 2)->nullable()->change();
            $table->double('active_loan_limit', 10, 2)->nullable()->change();
            $table->integer('points')->nullable()->change();
            $table->boolean('is_active')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // drop phone number column
            $table->dropColumn('phone_number');
            $table->foreignId('department_id')->nullable(false)->change();
            $table->foreignId('position_id')->nullable(false)->change();
            $table->string('nik')->nullable(false)->change();
            $table->string('fullname')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->date('dateofbirth')->nullable(false)->change();
            $table->enum('gender', [1, 2])->nullable(false)->change();
            $table->double('salary', 10, 2)->nullable(false)->change();
            $table->double('loan_limit', 10, 2)->nullable(false)->change();
            $table->double('active_loan_limit', 10, 2)->nullable(false)->change();
            $table->integer('points')->nullable(false)->change();
            $table->boolean('is_active')->nullable(false)->change();
        });
    }
};
