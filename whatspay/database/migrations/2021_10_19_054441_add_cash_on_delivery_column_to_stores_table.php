<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCashOnDeliveryColumnToStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('disount_type');
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->enum('cash_on_delivery', ['enable', 'disable'])->default('enable')->after('status');
            $table->enum('disount_type', ['flat', 'percentage'])->nullable();
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
