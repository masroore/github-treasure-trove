<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('location_code')->unique();
            $table->boolean('active')->default(0);
            $table->string('location_name');
            $table->string('street_address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('zip_code');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('square_foot')->nullable();
            $table->decimal('annual_budget', 15, 2)->nullable();
            $table->string('call_in_numbers')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
