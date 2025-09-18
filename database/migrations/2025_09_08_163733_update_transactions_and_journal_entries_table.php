<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // transactions: add unique reference, created_by, is_reversal, reversal_of_id, status
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'reference')) {
                $table->string('reference', 100)->unique()->after('id');
            } else {
                $table->unique('reference');
            }
            if (!Schema::hasColumn('transactions', 'transaction_date')) {
                $table->date('transaction_date')->index()->after('reference');
            } else {
                $table->index('transaction_date');
            }
            if (!Schema::hasColumn('transactions', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('transaction_date');
            }
            if (!Schema::hasColumn('transactions', 'is_reversal')) {
                $table->boolean('is_reversal')->default(false)->after('created_by');
            }
            if (!Schema::hasColumn('transactions', 'reversal_of_id')) {
                $table->unsignedBigInteger('reversal_of_id')->nullable()->after('is_reversal');
            }
            if (!Schema::hasColumn('transactions', 'status')) {
                $table->string('status', 20)->default('posted')->after('reversal_of_id');
            }
        });

        // journal_entries: add indexes and adjust decimals if needed
        Schema::table('journal_entries', function (Blueprint $table) {
            if (!Schema::hasColumn('journal_entries', 'debit')) {
                $table->decimal('debit', 15, 2)->default(0.00)->after('coa_id');
            } else {
                $table->decimal('debit', 15, 2)->change();
            }
            if (!Schema::hasColumn('journal_entries', 'credit')) {
                $table->decimal('credit', 15, 2)->default(0.00)->after('debit');
            } else {
                $table->decimal('credit', 15, 2)->change();
            }
            $table->index('transaction_id');
            $table->index('coa_id');
        });

        // optional: create payments/others etc handled elsewhere
    }

    public function down(): void
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->dropIndex(['transaction_id']);
            $table->dropIndex(['coa_id']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropUnique(['reference']);
            $table->dropIndex(['transaction_date']);
            if (Schema::hasColumn('transactions', 'created_by')) $table->dropColumn('created_by');
            if (Schema::hasColumn('transactions', 'is_reversal')) $table->dropColumn('is_reversal');
            if (Schema::hasColumn('transactions', 'reversal_of_id')) $table->dropColumn('reversal_of_id');
            if (Schema::hasColumn('transactions', 'status')) $table->dropColumn('status');
        });
    }
};
