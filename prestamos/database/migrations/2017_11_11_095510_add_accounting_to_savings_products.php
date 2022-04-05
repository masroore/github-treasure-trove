<?php

use Illuminate\Database\Migrations\Migration;

class AddAccountingToSavingsProducts extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('savings_products', function ($table): void {
            $table->enum('accounting_rule', [
                'none',
                'cash_based',
            ])->default('none')->nullable();
            $table->integer('chart_reference_id')->nullable();
            $table->integer('chart_overdraft_portfolio_id')->nullable();
            $table->integer('chart_savings_control_id')->nullable();
            $table->integer('chart_income_interest_id')->nullable();
            $table->integer('chart_income_fee_id')->nullable();
            $table->integer('chart_income_penalty_id')->nullable();
            $table->integer('chart_payable_interest_id')->nullable();
            $table->integer('chart_receivable_fee_id')->nullable();
            $table->integer('chart_receivable_penalty_id')->nullable();
            $table->integer('chart_expense_interest_id')->nullable();
            $table->integer('chart_expense_written_off_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('savings_products', function ($table): void {
            $table->dropColumn([
                'accounting_rule',
                'chart_reference_id',
                'chart_overdraft_portfolio_id',
                'chart_savings_control_id',
                'chart_income_interest_id',
                'chart_income_fee_id',
                'chart_income_penalty_id',
                'chart_expense_interest_id',
                'chart_expense_written_off_id',
                'chart_payable_interest_id',
                'chart_receivable_fee_id',
                'chart_receivable_penalty_id',
            ]);
        });
    }
}
