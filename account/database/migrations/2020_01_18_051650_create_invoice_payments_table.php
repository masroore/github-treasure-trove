<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'invoice_payments',
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->integer('invoice_id');
                $table->date('date');
                $table->float('amount')->default('0.00');
                $table->integer('account_id');
                $table->integer('payment_method');
                $table->string('reference');
                $table->text('description');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_payments');
    }
}
