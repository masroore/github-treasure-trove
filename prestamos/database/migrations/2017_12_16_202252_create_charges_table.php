<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('charges', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('name')->nullable();
            $table->enum('product', ['loan', 'savings']);
            $table->enum(
                'charge_type',
                [
                    'disbursement',
                    'specified_due_date',
                    'installment_fee',
                    'overdue_installment_fee',
                    'loan_rescheduling_fee',
                    'overdue_maturity',
                    'savings_activation',
                    'withdrawal_fee',
                    'annual_fee',
                    'monthly_fee',
                ]
            );
            $table->enum(
                'charge_option',
                [
                    'fixed',
                    'percentage',
                    'principal_due',
                    'principal_interest',
                    'interest_due',
                    'total_due',
                    'original_principal',
                ]
            );
            $table->tinyInteger('charge_frequency')->default(0);
            $table->enum(
                'charge_frequency_type',
                [
                    'days',
                    'weeks',
                    'months',
                    'years',
                ]
            )->default('days');
            $table->integer('charge_frequency_amount')->default(0);
            $table->decimal('amount', 65, 2)->nullable();
            $table->enum(
                'charge_payment_mode',
                [
                    'regular',
                    'account_transfer',
                ]
            )->default('regular');
            $table->integer('currency_id')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->tinyInteger('penalty')->default(0);
            $table->tinyInteger('override')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('charges');
    }
}
