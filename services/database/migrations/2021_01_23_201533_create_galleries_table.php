<?php
/*
 * File name: 2021_01_23_201533_create_galleries_table.php
 * Last modified: 2021.04.20 at 11:19:32
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table): void {
            $table->increments('id');
            $table->longText('description')->nullable();
            $table->integer('e_provider_id')->unsigned();
            $table->timestamps();
            $table->foreign('e_provider_id')->references('id')->on('e_providers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('galleries');
    }
}
