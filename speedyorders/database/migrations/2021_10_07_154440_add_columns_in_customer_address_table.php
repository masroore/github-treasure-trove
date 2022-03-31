<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInCustomerAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_addresses', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_addresses', 'a_first_name')) {
                $table->string('a_first_name', 255)->default(null)->nullable()->after('customer_user_id');
            }
            if (!Schema::hasColumn('customer_addresses', 'a_last_name')) {
                $table->string('a_last_name', 255)->default(null)->nullable()->after('a_first_name');
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
        Schema::table('customer_addresses', function (Blueprint $table) {

        });
    }
}
