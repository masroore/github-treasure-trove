<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('responsable_id')->unsigned();
            $table->integer('pre_invoice_id')->unsigned();
            $table->string('payment_method')->nullable();
            $table->bigInteger('value');
            $table->string('comment')->nullable();
            $table->timestamps();
            //$table->softDeletes();
        });

        Schema::table('payments', function (Blueprint $table): void {
            $table->foreign('responsable_id')
                ->references('id')->on('users')
                ->onDelete('restrict');

            $table->foreign('pre_invoice_id')
                ->references('id')->on('pre_invoices')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
}
