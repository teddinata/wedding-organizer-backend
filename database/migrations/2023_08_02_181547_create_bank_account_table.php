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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank', 15);
            $table->string('account_holder', 75);
            $table->string('account_number', 16);
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
            $table->index('account_holder');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_account');
    }
};
