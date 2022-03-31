<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInProductDeliveryTimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_deliverytime', function (Blueprint $table) {
            if (!Schema::hasColumn('product_deliverytime', 'shipping_zone_groups_id')) {
                $table->integer('shipping_zone_groups_id')->default(null)->nullable()->after('shipping_delivery_times_id');
            }
            if (!Schema::hasColumn('product_deliverytime', 'shipping_packages_id')) {
                $table->integer('shipping_packages_id')->default(null)->nullable()->after('shipping_zone_groups_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_deliverytime', function (Blueprint $table) {

        });
    }
}
