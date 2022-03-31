<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeTrackingsTable extends Migration
{
    public function up()
    {
        Schema::create('time_trackings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->time('checkin_time');
            $table->time('checkout_time')->nullable();
            $table->decimal('cost', 15, 2)->nullable();
            $table->integer('status');
            $table->string('ip_address')->nullable();
            $table->string('total_hours')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
