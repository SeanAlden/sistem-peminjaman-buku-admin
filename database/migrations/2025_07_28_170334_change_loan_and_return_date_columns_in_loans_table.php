<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dateTime('loan_date')->change();
            $table->dateTime('return_date')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->date('loan_date')->change();
            $table->date('return_date')->nullable()->change();
        });
    }
};
