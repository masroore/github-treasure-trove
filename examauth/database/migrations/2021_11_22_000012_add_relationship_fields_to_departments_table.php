<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDepartmentsTable extends Migration
{
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->unsignedBigInteger('hod_id');
            $table->foreign('hod_id', 'hod_fk_5390383')->references('id')->on('users');
            $table->unsignedBigInteger('faculty_id');
            $table->foreign('faculty_id', 'faculty_fk_5390392')->references('id')->on('faculties');
        });
    }
}
