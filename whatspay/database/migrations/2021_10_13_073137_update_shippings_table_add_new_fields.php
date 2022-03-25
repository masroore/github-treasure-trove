<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateShippingsTableAddNewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shippings', function (Blueprint $table) {
            $table->bigInteger('parent_id')->unsigned()->after('id')->nullable();
            $table->string('city', 160)->after('country')->nullable();
            $table->float('radius')->after('city')->nullable();
            $table->double('latitude')->after('radius')->nullable();
            $table->double('longitude')->after('latitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shippings', function (Blueprint $table) {

        });
    }
}
