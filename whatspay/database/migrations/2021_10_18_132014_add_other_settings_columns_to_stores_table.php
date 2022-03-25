<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherSettingsColumnsToStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->tinyInteger('is_tax_enable')->default(0)->after('orders_accept_status')->comment('store charges sales tax');
            $table->Integer('tax_rate')->default(0)->comment('If is_tax_enable 1');
            $table->tinyInteger('is_tax_included')->default(0)->comment('Display Product Price Including taxes');
            $table->tinyInteger('custom_tax_config')->default(0)->comment('Enable Custom tax config: 0 calculate tax on original price, 1 calculate tax on discounted price');
            $table->tinyInteger('allow_checkout_when_out_of_stock')->default(0)->comment('Automatically hide out of stock products');
            $table->Integer('min_order_price')->default(0)->comment('Limit Order By minimum price');
            $table->Integer('max_order_price')->default(0)->comment('Limit Order By maximum price');
            $table->Integer('min_order_qty')->default(0)->comment('Limit Order By minimum quantity');
            $table->Integer('max_order_qty')->default(0)->comment('Limit Order By maximum quantity');
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
