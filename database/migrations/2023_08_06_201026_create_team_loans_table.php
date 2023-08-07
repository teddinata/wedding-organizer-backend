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
            // relation team_id
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->string('loan_number')->nullable();
            $table->string('description')->nullable();
            $table->integer('amount')->nullable();
            $table->enum('status', ['waiting approval', 'on going', 'paid', 'rejected'])->default(null)->nullable();

            // created_by, updated_by, deleted_by
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            // soft delete
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
