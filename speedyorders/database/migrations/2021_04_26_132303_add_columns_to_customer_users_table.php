<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCustomerUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_users', function (Blueprint $table) {
            $table->string('token')->default(null)->nullbale()->after('password');
            $table->string('password_reset_at')->default(null)->nullbale()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_users', function (Blueprint $table) {
            $table->dropColumn('token');
            $table->dropColumn('password_reset_at');
        });
    }
}
