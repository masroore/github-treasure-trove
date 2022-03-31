<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToStudentProfilesTable extends Migration
{
    public function up()
    {
        Schema::table('student_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('faculty_id');
            $table->foreign('faculty_id', 'faculty_fk_5390434')->references('id')->on('faculties');
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id', 'department_fk_5390435')->references('id')->on('departments');
        });
    }
}
