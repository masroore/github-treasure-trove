<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDefaultValueOfColumnsToStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('service_charges_status');
            $table->dropColumn('cod_status');
            $table->dropColumn('disount_type');
            $table->dropColumn('auto_subscription');
            $table->dropColumn('orders_accept_status');
        });
        Schema::table('stores', function (Blueprint $table) {
            // $table->dropColumn('service_charges_status');
            // $table->dropColumn('cod_status');
            // $table->dropColumn('disount_type');
            // $table->dropColumn('auto_subscription');
            // $table->dropColumn('orders_accept_status');
            // $table->string('service_charges_status')->nullable()->change();
            // $table->string('cod_status')->nullable()->change();
            $table->enum('service_charges_status', ['include', 'exclude'])->default('exclude');
            $table->enum('cod_status', ['enable', 'disable'])->default('disable');
            // $table->enum('shipping_percentage_type',['flat','percentage'])->default('flat');
            $table->string('delivery_range')->nullable()->change();
            $table->enum('disount_type', ['off', 'on'])->nullable();
            $table->enum('auto_subscription', ['off', 'on'])->default('off');
            $table->enum('orders_accept_status', ['yes', 'no'])->default('no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {

        });
    }
}
