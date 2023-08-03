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
            // $table->foreignId('vendor_id')->nullable();
            // grade
            $table->string('name', 15);
            $table->string('description')->nullable();

            // relation
            // $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            // created by
            $table->integer('created_by')->nullable();
            // updated by
            $table->integer('updated_by')->nullable();
            // deleted by
            $table->integer('deleted_by')->nullable();
            // soft delete
            $table->softDeletes();
            $table->timestamps();

            // index
            $table->index('name');
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
