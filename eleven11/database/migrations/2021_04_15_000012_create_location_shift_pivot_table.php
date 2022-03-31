<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationShiftPivotTable extends Migration
{
    public function up()
    {
        Schema::create('location_shift', function (Blueprint $table) {
            $table->unsignedBigInteger('shift_id');
            $table->foreign('shift_id', 'shift_id_fk_3688552')->references('id')->on('shifts')->onDelete('cascade');
            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id', 'location_id_fk_3688552')->references('id')->on('locations')->onDelete('cascade');
        });
    }
}
