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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            // logo
            $table->string('logo')->nullable();
            $table->string('code')->nullable();
            $table->string('name');
            // point
            $table->integer('point')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            // address use longtext
            $table->longText('address')->nullable();
            $table->string('city')->nullable();
            // limit_id
            $table->foreignId('limit_id')->nullable();
            // grade_id
            $table->foreignId('grade_id')->nullable();
            // membership_id
            $table->foreignId('membership_id')->nullable();

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
            $table->index('code');
            $table->index('name');
            $table->index('point');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
