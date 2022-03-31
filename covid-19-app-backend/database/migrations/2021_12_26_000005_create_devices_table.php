<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('udid')->nullable();
            $table->string('token')->nullable();
            $table->string('key')->nullable();
            $table->date('date_test')->nullable();
            $table->boolean('covid')->default(0)->nullable();
            $table->boolean('risk')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
