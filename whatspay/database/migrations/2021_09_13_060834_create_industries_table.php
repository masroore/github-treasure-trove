<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndustriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id')->unsigned()->default(0);
            $table->string('name', 50)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('icon', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Schema::table('industries',function (Blueprint $table){
        //     $table->foreign('parent_id')->references('id')->on('industries');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('industries');
        Schema::table('industries', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
