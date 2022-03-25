<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuardianinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardianinfos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('osncode_id')->nullable();
            $table->string('gurdianname')->nullable();
            $table->string('relationshp')->nullable();
            $table->string('occupation')->nullable();
            $table->string('mobile')->nullable();
            $table->string('employed')->nullable();
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
        Schema::dropIfExists('guardianinfos');
    }
}
