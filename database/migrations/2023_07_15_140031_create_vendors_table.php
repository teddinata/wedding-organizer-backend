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
            $table->string('cover_photo')->nullable();
            $table->string('logo')->nullable();
            $table->string('code');
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('person_level')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->longText('address')->nullable();
            $table->string('city')->nullable();
            $table->foreignId('vendor_limit_id')->references('id')->on('vendor_limits')->onDelete('cascade');
            $table->foreignId('vendor_grade_id')->references('id')->on('vendor_grades')->onDelete('cascade');
            $table->foreignId('membership_id')->references('id')->on('memberships')->onDelete('cascade');
            $table->integer('point')->default(0);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('otp')->nullable();
            $table->timestamp('otp_verified_at')->nullable();
            $table->string('reset_token')->nullable();
            $table->string('notification_token')->nullable();
            $table->string('otp_email')->nullable();
            $table->boolean('is_first_login')->default(true); // check login first time for mobile
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // index
            $table->index('code');
            $table->index('name');
            $table->index('email');
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
