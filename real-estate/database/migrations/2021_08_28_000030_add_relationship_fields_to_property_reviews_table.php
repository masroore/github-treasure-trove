<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPropertyReviewsTable extends Migration
{
    public function up()
    {
        Schema::table('property_reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id', 'property_fk_4565296')->references('id')->on('properties');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_4565295')->references('id')->on('users');
        });
    }
}
