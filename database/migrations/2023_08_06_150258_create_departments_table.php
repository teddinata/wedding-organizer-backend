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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');

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
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
