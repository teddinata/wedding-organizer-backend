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
        Schema::create('membership_benefits', function (Blueprint $table) {
            $table->id();
            // membership_id
            $table->foreignId('membership_id')->nullable();
            // image
            $table->string('image')->nullable();
            // name
            $table->string('description')->nullable();

            // relation
            $table->foreign('membership_id')->references('id')->on('memberships')->onDelete('cascade');

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
        Schema::dropIfExists('membership_benefits');
    }
};
