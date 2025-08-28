<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->integer('queue_position'); // Untuk menentukan urutan dalam antrian
            $table->enum('status', ['pending', 'available', 'completed', 'cancelled', 'expired'])->default('pending');
            $table->timestamp('notified_at')->nullable(); // Waktu saat user diberi tahu buku tersedia
            $table->timestamp('expires_at')->nullable(); // Batas waktu pengambilan buku
            $table->timestamps();

            // Memastikan user tidak bisa mereservasi buku yang sama dua kali jika statusnya masih pending
            $table->unique(['user_id', 'book_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};