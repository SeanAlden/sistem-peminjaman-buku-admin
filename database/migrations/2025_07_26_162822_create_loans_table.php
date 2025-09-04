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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->dateTime('loan_date');
            $table->dateTime('return_date')->nullable();
            $table->dateTime('actual_returned_at')->nullable();

            $table->enum('status', ['borrowed', 'returned'])->default('borrowed');

            $table->integer('loan_duration')->default(7);
            $table->dateTime('max_returned_at')->nullable();

            $table->integer('late_days')->default(0);
            $table->integer('fine_amount')->default(0);

            $table->enum('return_status_note', [
                'Returned Earlier',
                'Returned On Time',
                'Late Within Allowed Duration',
                'Overdue'
            ])->nullable();

            $table->timestamps();

            // Foreign Keys
            $table->foreign('book_id')
                ->references('id')->on('books')
                ->onDelete('cascade')
                ->onUpdate('no action');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
