<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWorkingDaysToStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->bigInteger('parent_branch_id')->unsigned()->comment('Belongs to stores table PK')->after('user_id');
            $table->renameColumn('cash_on_delivery', 'cod_status');
            $table->renameColumn('service_charges', 'service_charges_status');
            $table->renameColumn('store_service_charges', 'service_charges_amount');
            $table->renameColumn('delivery_rangeIndex', 'delivery_range');
            $table->renameColumn('service_option', 'service_options');
            $table->text('store_timings')->nullable()->after('delivery_radius');
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
            $table->renameColumn('cod_status', 'cash_on_delivery');
            $table->renameColumn('service_charges_status', 'service_charges');
            $table->renameColumn('service_charges_amount', 'store_service_charges');
            $table->renameColumn('delivery_range', 'delivery_rangeIndex');
            $table->renameColumn('service_options', 'service_option');
        });
    }
}
