<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWallettopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallettops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tr_id');
            $table->string('fullname');
            $table->string('indexnumber');
            $table->string('amount');
            $table->string('status')->default('uppaid');
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
        Schema::dropIfExists('wallettops');
    }
}
