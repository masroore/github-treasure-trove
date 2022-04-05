<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLoansProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loan_products', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('name')->nullable();
            $table->text('loan_disbursed_by_id')->nullable();
            $table->decimal('minimum_principal', 10, 4)->nullable();
            $table->decimal('default_principal', 10, 4)->nullable();
            $table->decimal('maximum_principal', 10, 4)->nullable();
            $table->enum('interest_method', [
                'flat_rate',
                'declining_balance_equal_installments',
                'declining_balance_equal_principal',
                'interest_only',
                'compound_interest',
            ])->default('flat_rate');
            $table->decimal('interest_rate', 10, 4)->nullable();
            $table->enum('interest_period', [
                'day',
                'week',
                'month',
                'year',
            ])->default('year');
            $table->decimal('minimum_interest_rate', 10, 4)->nullable();
            $table->decimal('default_interest_rate', 10, 4)->nullable();
            $table->decimal('maximum_interest_rate', 10, 4)->nullable();
            $table->tinyInteger('override_interest')->default(0);
            $table->decimal('override_interest_amount', 10, 4)->default(0.00);
            $table->integer('default_loan_duration')->nullable();
            $table->enum('default_loan_duration_type', [
                'day',
                'week',
                'month',
                'year',
            ])->default('year');
            $table->enum('repayment_cycle', [
                'daily',
                'weekly',
                'monthly',
                'bi_monthly',
                'quarterly',
                'semi_annually',
                'annually',
            ])->default('monthly');
            $table->enum(
                'decimal_places',
                ['round_off_to_two_decimal', 'round_off_to_integer']
            )->default('round_off_to_two_decimal');
            $table->text('repayment_order')->nullable();
            $table->enum('loan_fees_schedule', [
                'dont_include',
                'distribute_fees_evenly',
                'charge_fees_on_released_date',
                'charge_fees_on_first_payment',
                'charge_fees_on_last_payment',
            ])->default('distribute_fees_evenly')->nullable();
            $table->string('branch_access')->nullable();
            $table->integer('grace_on_interest_charged')->nullable();
            $table->tinyInteger('advanced_enabled')->default(0)->nullable();
            $table->tinyInteger('enable_late_repayment_penalty')->default(0)->nullable();
            $table->tinyInteger('enable_after_maturity_date_penalty')->default(0)->nullable();
            $table->enum(
                'after_maturity_date_penalty_type',
                ['percentage', 'fixed']
            )->default('percentage')->nullable();
            $table->enum(
                'late_repayment_penalty_type',
                ['percentage', 'fixed']
            )->default('percentage')->nullable();
            $table->enum(
                'late_repayment_penalty_calculate',
                [
                    'overdue_principal',
                    'overdue_principal_interest',
                    'overdue_principal_interest_fees',
                    'total_overdue',
                ]
            )->default('overdue_principal')->nullable();
            $table->enum(
                'after_maturity_date_penalty_calculate',
                [
                    'overdue_principal',
                    'overdue_principal_interest',
                    'overdue_principal_interest_fees',
                    'total_overdue',
                ]
            )->default('overdue_principal')->nullable();
            $table->decimal('late_repayment_penalty_amount', 10, 4)->nullable();
            $table->decimal('after_maturity_date_penalty_amount', 10, 4)->nullable();
            $table->integer('late_repayment_penalty_grace_period')->nullable();
            $table->integer('after_maturity_date_penalty_grace_period')->nullable();
            $table->integer('late_repayment_penalty_recurring')->nullable();
            $table->integer('after_maturity_date_penalty_recurring')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('loan_products');
    }
}
