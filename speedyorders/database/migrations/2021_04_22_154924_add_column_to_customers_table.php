<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_user_id')->default(null)->nullable()->after('uuid');
            $table->string('phone')->default(null)->nullable()->after('telephone');
            $table->string('address1')->default(null)->nullable()->after('telephone');
            $table->string('address2')->default(null)->nullable()->after('telephone');
            $table->string('postal_code')->default(null)->nullable()->after('telephone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('customer_user_id');
            $table->dropColumn('phone');
            $table->dropColumn('address1');
            $table->dropColumn('address2');
            $table->dropColumn('postal_code');
        });
    }
}
