<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('book_predictions', function (Blueprint $table) {
            $table->float('des_prediction')->nullable()->after('predicted_popularity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_predictions', function (Blueprint $table) {
            $table->dropColumn('des_prediction');
        });
    }
};
