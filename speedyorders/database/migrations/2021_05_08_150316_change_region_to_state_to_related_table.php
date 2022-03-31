<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeRegionToStateToRelatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->dropColumn('country');
            $table->dropColumn('region_id');
        });

        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->unsignedBigInteger('country')->default(null)->nullable();
            $table->string('state')->default(null)->nullable();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_region');
            $table->dropColumn('shipping_region');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_state')->default(null)->nullable();
            $table->string('shipping_state')->default(null)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('state_to_related', function (Blueprint $table) {

        });
    }
}
