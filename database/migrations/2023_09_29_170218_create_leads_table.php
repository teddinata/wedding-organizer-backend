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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            // vendor id
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->onDelete('cascade');

            $table->datetime('date')->nullable();
            $table->string('pic')->nullable();
            $table->enum('response', ['yes', 'no'])->nullable();
            $table->string('code')->nullable();
            $table->text('note')->nullable();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
