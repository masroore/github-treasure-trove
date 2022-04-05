<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTariffZoneToCdek extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("
            CREATE TABLE IF NOT EXISTS `cdek_cities` (
              `id` integer(10) NOT NULL,
              `search` varchar(64) NOT NULL,
              `city` varchar(64) NOT NULL,
              `region` varchar(64) NOT NULL,
              `center` tinyint(1) NOT NULL DEFAULT '0',
              `cache_limit` float(5,4) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
        ");

        Schema::table('cdek_cities', function (Blueprint $table) {
            $table->tinyInteger('tariff_zone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cdek_cities', function (Blueprint $table) {
            $table->dropColumn('tariff_zone');
        });
    }
}
