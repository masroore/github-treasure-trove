<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentgroupingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentgroupings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('indexnumber');
            $table->string('studentname')->nullable();
            $table->string('year');
            $table->string('semester');
            $table->string('lecname');
            $table->string('lecid');
            $table->string('capacity');
            $table->string('group')->nullable();
            $table->string('session');
            $table->string('coursecode');
            $table->string('level')->nullable();
            $table->string('progcode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('studentgroupings');
    }
}
