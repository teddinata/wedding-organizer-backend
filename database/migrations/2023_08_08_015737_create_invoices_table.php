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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('bank_account_id')->constrained('bank_accounts')->onDelete('cascade');

            // invoice number
            $table->string('invoice_code')->unique();
            $table->string('transfer_proof')->nullable();
            $table->date('transfer_date')->nullable();
            $table->unsignedBigInteger('transfer_proof_uploaded_by')->nullable();
            $table->timestamp('transfer_proof_uploaded_at')->nullable();
            $table->enum('status', ['waiting for payment', 'paid', 'canceled'])->default('waiting for payment');

            // created by, updated by, deleted by
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
