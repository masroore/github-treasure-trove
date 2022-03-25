<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lecturer_id');
            $table->string('title');
            $table->string('totalquestion');
            $table->string('questiontoshow');
            $table->string('mfr');
            $table->string('mfw');
            $table->string('minutes');
            $table->string('description');
            $table->string('retry');
            $table->string('programme')->nullable();
            $table->string('academicyear')->nullable();
            $table->string('semester')->nullable();
            $table->string('fullname')->nullable();
            $table->string('coursecode');
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
        Schema::dropIfExists('exams');
    }
}
