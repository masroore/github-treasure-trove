<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableShippingRulesUpdateColumnNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_rules', function (Blueprint $table) {
            $table->renameColumn('from', 'min');
            $table->renameColumn('to', 'max');
            $table->renameColumn('price', 'charges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_rules', function (Blueprint $table) {

        });
    }
}
