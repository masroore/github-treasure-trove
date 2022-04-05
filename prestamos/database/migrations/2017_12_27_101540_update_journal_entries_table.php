<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UpdateJournalEntriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE journal_entries CHANGE COLUMN transaction_type transaction_type ENUM('repayment',
                    'disbursement',
                    'accrual',
                    'deposit',
                    'withdrawal',
                    'manual_entry',
                    'pay_charge',
                    'transfer_fund',
                    'expense',
                    'payroll',
                    'income',
                    'fee',
                    'penalty',
                    'interest',
                    'dividend',
                     'guarantee',
                    'close_write_off',
                    'repayment_disbursement',
                    'repayment_recovery',
                    'interest_accrual',
                    'fee_accrual') DEFAULT 'repayment'");
        Schema::table('journal_entries', function ($table): void {
            $table->integer('loan_transaction_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->enum(
                'transaction_sub_type',
                [
                    'overpayment',
                    'repayment_interest',
                    'repayment_principal',
                    'repayment_fees',
                    'repayment_penalty',
                ]
            )->nullable();
            $table->tinyInteger('reversed')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('journal_entries', function ($table): void {
            $table->dropColumn('loan_transaction_id');
            $table->dropColumn('transaction_sub_type');
            $table->dropColumn('branch_id');
        });
    }
}
