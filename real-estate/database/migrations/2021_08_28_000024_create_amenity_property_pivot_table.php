<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmenityPropertyPivotTable extends Migration
{
    public function up()
    {
        Schema::create('amenity_property', function (Blueprint $table) {
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id', 'property_id_fk_4565220')->references('id')->on('properties')->onDelete('cascade');
            $table->unsignedBigInteger('amenity_id');
            $table->foreign('amenity_id', 'amenity_id_fk_4565220')->references('id')->on('amenities')->onDelete('cascade');
        });
    }
}
