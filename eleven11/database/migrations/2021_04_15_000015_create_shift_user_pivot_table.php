<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('shift_user', function (Blueprint $table) {
            $table->unsignedBigInteger('shift_id');
            $table->foreign('shift_id', 'shift_id_fk_3687810')->references('id')->on('shifts')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_3687810')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
