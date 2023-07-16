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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            // icon
            $table->string('icon')->nullable();
            // name
            $table->string('name')->nullable();
            // from
            $table->integer('from')->nullable();
            // to
            $table->integer('until')->nullable();
            // point
            $table->integer('point')->nullable();
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
        Schema::dropIfExists('memberships');
    }
};
