<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // 1. Drop foreign key constraints (pastikan pakai nama yg benar)
            $table->dropForeign(['user_id']);
            $table->dropForeign(['book_id']);

            // 2. Drop unique index
            $table->dropUnique('reservations_user_id_book_id_status_unique');

            // 3. Re-add foreign keys (tanpa unique constraint)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Rollback: drop FKs dulu
            $table->dropForeign(['user_id']);
            $table->dropForeign(['book_id']);

            // Tambahkan lagi unique index
            $table->unique(['user_id', 'book_id', 'status'], 'reservations_user_id_book_id_status_unique');

            // Tambahkan kembali FKs
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }
};
