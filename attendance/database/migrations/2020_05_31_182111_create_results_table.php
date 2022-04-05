<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('osncode_id')->nullable();
            $table->string('resulttype')->nullable();
            $table->string('examtype')->nullable();
            $table->string('examyear')->nullable();
            $table->string('indexnumber')->nullable();
            $table->string('subject1')->nullable();
            $table->string('grade1')->nullable();
            $table->integer('grad1')->nullable();
            $table->string('subject2')->nullable();
            $table->string('grade2')->nullable();
            $table->integer('grad2')->nullable();
            $table->string('subject3')->nullable();
            $table->string('grade3')->nullable();
            $table->integer('grad3')->nullable();
            $table->string('subject4')->nullable();
            $table->string('grade4')->nullable();
            $table->integer('grad4')->nullable();
            $table->string('subject5')->nullable();
            $table->string('grade5')->nullable();
            $table->integer('grad5')->nullable();
            $table->string('subject6')->nullable();
            $table->string('grade6')->nullable();
            $table->integer('grad6')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
}
