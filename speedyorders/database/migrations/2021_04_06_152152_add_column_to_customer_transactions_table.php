<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCustomerTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->default(null)->nullable();
            $table->unsignedBigInteger('referer_id')->default(null)->nullable();
            $table->enum('type', ['debit', 'credit'])->default(null)->nullable();
            $table->enum('status', ['initialize', 'pending', 'completed'])->default('initialize')->nullable();
            $table->string('currency')->default(null)->nullable();
            $table->string('remarks')->default(null)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_transactions', function (Blueprint $table) {
            $table->dropColumn('order_id');
            $table->dropColumn('referer_id');
            $table->dropColumn('type');
            $table->dropColumn('status');
            $table->dropColumn('currency');
            $table->dropColumn('remarks');
        });
    }
}
