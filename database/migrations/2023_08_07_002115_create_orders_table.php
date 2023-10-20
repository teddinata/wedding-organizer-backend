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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->nullable();
            $table->string('order_seq')->nullable();
            $table->date('date')->nullable();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->date('loading_date')->nullable();
            $table->time('loading_time')->nullable();
            $table->date('event_date')->nullable();
            $table->time('event_time')->nullable();
            $table->string('venue')->nullable();
            $table->string('room')->nullable();
            $table->foreignId('sales_id')->constrained('sales')->cascadeOnDelete();
            $table->foreignId('coordinator_id')->constrained('employees')->cascadeOnDelete();
            $table->enum('coordinator_schedule', ['1', '2'])->default(null)->nullable()->comment('Status: 1 = visit, 2 = standby');
            $table->integer('subtotal')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('total')->nullable();
            $table->string('notes')->nullable();
            // is_checklist_tree (0: no, 1: yes) boolean
            $table->boolean('is_checklist_tree')->default(0)->nullable();
            $table->boolean('is_checklist_melamin')->default(0)->nullable();
            $table->boolean('is_checklist_lighting')->default(0)->nullable();
            $table->boolean('is_checklist_gazebo')->default(0)->nullable();
            $table->integer('reward_point')->nullable();
            $table->integer('extra_point')->nullable();
            // created_by, updated_by, deleted_by
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // index
            $table->index('order_number');
            $table->index('order_seq');
            $table->index('date');
            $table->index('loading_date');
            $table->index('loading_time');
            $table->index('event_date');
            $table->index('event_time');
            $table->index('venue');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
