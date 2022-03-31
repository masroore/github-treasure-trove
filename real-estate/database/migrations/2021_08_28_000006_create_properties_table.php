<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('property_title')->unique();
            $table->longText('property_description');
            $table->integer('rooms');
            $table->decimal('property_price', 15, 2);
            $table->string('per');
            $table->longText('google_map_location');
            $table->date('year_built');
            $table->integer('area');
            $table->string('property_video');
            $table->string('status')->nullable();
            $table->boolean('available')->default(0);
            $table->boolean('feature_property')->default(0)->nullable();
            $table->string('location');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
