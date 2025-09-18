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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Relasi ke employees (nullable, jika employee dihapus -> SET NULL)
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')
                  ->references('id')->on('employees')
                  ->onDelete('set null');

            // Relasi ke suppliers (nullable, jika supplier dihapus -> SET NULL)
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')
                  ->references('id')->on('suppliers')
                  ->onDelete('set null');

            $table->decimal('amount', 12, 2);
            $table->date('payment_date');
            $table->enum('method', ['cash', 'transfer', 'other'])->default('cash');
            $table->text('notes')->nullable();

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
