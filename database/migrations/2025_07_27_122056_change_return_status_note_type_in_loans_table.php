<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->enum('return_status_note', [
                'Returned Earlier',
                'Returned On Time',
                'Late Within Allowed Duration',
                'Overdue'
            ])->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->string('return_status_note')->nullable()->change();
        });
    }
};
