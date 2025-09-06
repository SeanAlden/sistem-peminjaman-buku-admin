<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Menambahkan 'pending_return' ke dalam ENUM
        DB::statement("ALTER TABLE loans CHANGE COLUMN status status ENUM('borrowed', 'pending_return', 'returned') NOT NULL DEFAULT 'borrowed'");
    }

    public function down(): void
    {
        // Mengembalikan ke state semula jika migrasi di-rollback
        DB::statement("ALTER TABLE loans CHANGE COLUMN status status ENUM('borrowed', 'returned') NOT NULL DEFAULT 'borrowed'");
    }
};