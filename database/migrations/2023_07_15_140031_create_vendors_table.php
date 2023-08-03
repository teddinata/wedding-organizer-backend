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
            // limit_id
            $table->foreignId('vendor_limit_id');
            // grade_id
            $table->foreignId('vendor_grade_id');
            // membership_id
            $table->foreignId('membership_id');

            // logo
            $table->string('logo')->nullable();
            $table->string('code', 7);
            $table->string('name');
            // point
            $table->integer('point')->default(0);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            // otp password
            $table->string('otp')->nullable();
            $table->timestamp('otp_verified_at')->nullable();
            // reset token
            $table->string('reset_token')->nullable();
            // notification token
            $table->string('notification_token')->nullable();
            // otp email
            $table->string('otp_email')->nullable();
            // check login first time for mobile
            $table->boolean('is_first_login')->default(1);
            $table->string('contact_person');
            $table->string('contact_number', 15);
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            // address use longtext
            $table->longText('address');
            $table->string('city', 50);

            // relationship
            // limit_id
            $table->foreign('vendor_limit_id')->references('id')->on('vendor_limits')->onDelete('cascade');
            // grade_id
            $table->foreign('vendor_grade_id')->references('id')->on('vendor_grades')->onDelete('cascade');
            // membership_id
            $table->foreign('membership_id')->references('id')->on('memberships')->onDelete('cascade');

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
