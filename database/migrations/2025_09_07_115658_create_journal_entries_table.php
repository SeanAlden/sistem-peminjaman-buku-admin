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
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke transactions
            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')
                  ->references('id')->on('transactions')
                  ->onDelete('cascade');

            // Foreign key ke chart_of_accounts
            $table->unsignedBigInteger('coa_id');
            $table->foreign('coa_id')
                  ->references('id')->on('chart_of_accounts')
                  ->onDelete('cascade');

            $table->decimal('debit', 12, 2)->default(0.00);
            $table->decimal('credit', 12, 2)->default(0.00);

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_entries');
    }
};
