<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('area', 100)->after('postal_code')->nullable();
            $table->tinyInteger('is_online')->default(0)->after('country');
            $table->string('phone_number', 16)->after('is_online')->nullable();
            $table->string('mobile_number', 16)->after('phone_number')->nullable();
            $table->string('ntn_num', 256)->after('website')->nullable();
            $table->string('acc_number', 50)->after('bank_name')->nullable();
            $table->string('iban_number', 50)->after('acc_number')->nullable();
            $table->string('state', 16)->after('city')->nullable();
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
