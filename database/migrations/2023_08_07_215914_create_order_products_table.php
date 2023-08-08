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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            // order id
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            // product attribute id
            $table->foreignId('product_attribute_id')->constrained('product_attributes')->cascadeOnDelete();
            // area id from decoration area
            $table->foreignId('area_id')->constrained('decoration_areas')->cascadeOnDelete();

            $table->string('slug')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('quantity')->default(1);
            $table->text('notes')->nullable();

            // created by, updated by, deleted by
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
