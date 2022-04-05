<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddTransferTypeToSavingTransactions extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE savings_transactions CHANGE COLUMN type type ENUM( 'deposit',
                'withdrawal',
                'bank_fees',
                'interest',
                'dividend',
                'guarantee',
                'guarantee_restored',
                'fees_payment',
                'transfer_loan',
                'transfer_savings')");
        Schema::table('savings_transactions', function ($table): void {
            $table->integer('reference')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('savings_transactions', function ($table): void {
            $table->dropColumn('reference');
        });
    }
}
