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
        Schema::table('order_products', function (Blueprint $table) {
            // add product_variant_id column
            $table->foreignId('product_variant_id')->constrained('product_variants')->cascadeOnDelete()->after('product_attribute_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_products', function (Blueprint $table) {
            // drop product_variant_id column
            $table->dropColumn('product_variant_id');
        });
    }
};
