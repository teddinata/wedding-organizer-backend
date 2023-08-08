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
        Schema::create('vendor_limits', function (Blueprint $table) {
            $table->id();
            // vendor_id
            // $table->foreignId('vendor_id')->nullable();
            // limit
            $table->string('name');
            $table->integer('amount_limit');

            // relation
            // $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            // created by
            $table->integer('created_by');
            // updated by
            $table->integer('updated_by')->nullable();
            // deleted by
            $table->integer('deleted_by')->nullable();
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
        Schema::dropIfExists('vendor_limits');
    }
};
