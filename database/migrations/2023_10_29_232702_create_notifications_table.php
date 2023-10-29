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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID pengguna yang akan menerima notifikasi
            $table->string('type'); // Tipe notifikasi (misalnya, "vendor_created")
            $table->json('data')->nullable(); // Kolom untuk data notifikasi (opsional, dapat berisi JSON)
            $table->timestamp('read_at')->nullable(); // Waktu notifikasi dibaca (kosongkan jika belum dibaca)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
