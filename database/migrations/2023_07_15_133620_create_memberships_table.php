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
        Schema::dropIfExists('memberships');
    }
};
