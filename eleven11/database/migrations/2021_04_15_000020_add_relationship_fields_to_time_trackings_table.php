<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTimeTrackingsTable extends Migration
{
    public function up()
    {
        Schema::table('time_trackings', function (Blueprint $table) {
            $table->unsignedBigInteger('random_code_id');
            $table->foreign('random_code_id', 'random_code_fk_3581405')->references('id')->on('random_codes');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_3581407')->references('id')->on('users');
            $table->unsignedBigInteger('shift_id');
            $table->foreign('shift_id', 'shift_fk_3582226')->references('id')->on('shifts');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id', 'location_fk_3670427')->references('id')->on('locations');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id', 'company_fk_3674998')->references('id')->on('companies');
        });
    }
}
