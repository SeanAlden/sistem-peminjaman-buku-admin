<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->string('return_status_note')->nullable();
            $table->integer('late_days')->default(0);
            $table->integer('fine_amount')->default(0);
        });
    }

    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['return_status_note', 'late_days', 'fine_amount']);
        });
    }
};
