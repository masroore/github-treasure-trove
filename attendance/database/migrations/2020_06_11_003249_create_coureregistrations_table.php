<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoureregistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coureregistrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('lecturer_id')->nullable();
            $table->string('indexnumber')->nullable();
            $table->string('level')->nullable();
            $table->string('cource_code')->nullable();
            $table->string('cource_title')->nullable();
            $table->string('credithours')->nullable();
            $table->string('IA_mark')->nullable();
            $table->string('exams_mark')->nullable();
            $table->string('total_marks')->nullable();
            $table->string('grade')->nullable();
            $table->string('grade_point')->nullable();
            $table->string('total_gp')->nullable();
            $table->string('semester')->nullable();
            $table->string('session')->nullable();
            $table->string('academic_year')->nullable();
            $table->string('status')->nullable();
            $table->string('resit')->default('0');
            $table->string('fvrt')->default('0');
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
        Schema::dropIfExists('coureregistrations');
    }
}
