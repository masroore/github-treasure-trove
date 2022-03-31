<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyPropertyTagPivotTable extends Migration
{
    public function up()
    {
        Schema::create('property_property_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id', 'property_id_fk_4565230')->references('id')->on('properties')->onDelete('cascade');
            $table->unsignedBigInteger('property_tag_id');
            $table->foreign('property_tag_id', 'property_tag_id_fk_4565230')->references('id')->on('property_tags')->onDelete('cascade');
        });
    }
}
