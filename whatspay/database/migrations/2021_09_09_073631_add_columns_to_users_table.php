<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('parent_id')->unsigned()->default(0)->after('id');
            $table->enum('user_type', ['visitor', 'company', 'employee'])->after('parent_id');
            $table->integer('user_status')->default(0)->after('user_type');
            $table->string('country_code', 5)->after('user_status');
            $table->string('wp_num_inc_code', 16)->after('country_code');
            $table->string('wp_num_exc_code', 16)->after('wp_num_inc_code');
            $table->string('activation_code')->nullable()->after('wp_num_exc_code');
            $table->string('activation_key', 64)->nullable()->after('activation_code');
            $table->string('forgot_pass', 64)->nullable()->after('activation_key');
            $table->string('image', 400)->nullable()->after('forgot_pass');
            $table->text('email_reset_hash')->nullable()->after('image');
            $table->tinyInteger('is_user_deactivated')->default(0)->after('email_reset_hash');
            // $table->date('confirmed_at')->after('is_user_deactivated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

        });
    }
}
