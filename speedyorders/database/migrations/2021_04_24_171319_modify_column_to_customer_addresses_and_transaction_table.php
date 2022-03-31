<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnToCustomerAddressesAndTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->dropColumn('customer_id');
            $table->unsignedBigInteger('customer_user_id')->nullable()->default(null)->after('id');
        });

        Schema::table('customer_transactions', function (Blueprint $table) {
            $table->dropColumn('customer_id');
            $table->unsignedBigInteger('customer_user_id')->nullable()->default(null)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
