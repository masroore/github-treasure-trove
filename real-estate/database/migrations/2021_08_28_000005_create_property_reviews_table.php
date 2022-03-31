<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('property_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->integer('ratings');
            $table->string('email');
            $table->longText('review');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
