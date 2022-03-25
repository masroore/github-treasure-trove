<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffmeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffmeetings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('zoomid');
            $table->string('user_id');
            $table->string('uuid');
            $table->string('created_by_id');
            $table->string('created_by');
            $table->string('title');
            $table->string('starttime');
            $table->string('duration');
            $table->string('join_url');
            $table->string('start_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staffmeetings');
    }
}
