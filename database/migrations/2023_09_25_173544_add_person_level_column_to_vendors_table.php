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
        Schema::table('vendors', function (Blueprint $table) {
            // add person_level column to vendors table
            $table->string('person_level')->nullable()->after('contact_person');
            $table->string('cover_photo')->nullable()->after('logo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            // drop person_level column to vendors table
            $table->dropColumn('person_level');
            $table->dropColumn('cover_photo');
        });
    }
};
