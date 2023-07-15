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
        Schema::create('vendor_grades', function (Blueprint $table) {
            $table->id();
            // vendor_id
            $table->foreignId('vendor_id')->nullable();
            // grade
            $table->string('name')->nullable();
            $table->string('description')->nullable();

            // relation
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');

            // soft delete
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_grades');
    }
};
