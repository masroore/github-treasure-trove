<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRandomCodesTable extends Migration
{
    public function up()
    {
        Schema::create('random_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->integer('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
