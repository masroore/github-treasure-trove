<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('f_image')->default(null)->nullable();
            $table->string('f_title')->default(null)->nullable();
            $table->text('f_description')->default(null)->nullable();
            $table->string('f_button_text')->default(null)->nullable();
            $table->string('f_link')->default(null)->nullable();
            $table->string('s_image')->default(null)->nullable();
            $table->string('s_title')->default(null)->nullable();
            $table->text('s_description')->default(null)->nullable();
            $table->string('s_button_text')->default(null)->nullable();
            $table->string('s_link')->default(null)->nullable();
            $table->string('t_image')->default(null)->nullable();
            $table->string('t_title')->default(null)->nullable();
            $table->text('t_description')->default(null)->nullable();
            $table->string('t_button_text')->default(null)->nullable();
            $table->string('t_link')->default(null)->nullable();
            $table->integer('sort_order')->default(1)->nullable();
            $table->string('status')->default('1')->comment('1=>Active,0=>InActive')->nullable();
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
        Schema::dropIfExists('banners');
    }
}
