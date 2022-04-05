<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddDebitCreditToSavingsTransactionsTable extends Migration
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
                'transfer')");
        Schema::table('savings_transactions', function ($table): void {
            $table->string('receipt')->nullable();
            $table->string('payment_method_id')->nullable();
            $table->decimal('debit', 65, 4)->nullable();
            $table->decimal('credit', 65, 4)->nullable();
            $table->decimal('balance', 65, 4)->nullable();
            $table->tinyInteger('reversible')->default(0);
            $table->tinyInteger('reversed')->default(0);
            $table->enum(
                'reversal_type',
                [
                    'system',
                    'user',
                    'none',
                ]
            )->default('none');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('savings_transactions', function ($table): void {
            $table->dropColumn('debit');
            $table->dropColumn('receipt');
            $table->dropColumn('fees_payment');
            $table->dropColumn('payment_method_id');
            $table->dropColumn('credit');
            $table->dropColumn('balance');
            $table->dropColumn('reversible');
            $table->dropColumn('reversed');
            $table->dropColumn('reversal_type');
        });
    }
}
