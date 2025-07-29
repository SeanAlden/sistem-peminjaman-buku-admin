<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->enum('return_status_note', [
                'returned_on_time',
                'late_within_allowed_duration',
                'overdue'
            ])->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->string('return_status_note')->nullable()->change();
        });
    }
};
