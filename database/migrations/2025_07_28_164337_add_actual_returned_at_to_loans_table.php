<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dateTime('actual_returned_at')->nullable()->after('return_date');
        });
    }

    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('actual_returned_at');
        });
    }

};
