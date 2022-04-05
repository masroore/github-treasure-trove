<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationTypesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evaluation_types', function (Blueprint $table): void {
            $table->increments('id');
            $table->text('name');
        });

        Schema::create('course_evaluation_type', function (Blueprint $table): void {
            //$table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->integer('evaluation_type_id')->unsigned();
        });

        Schema::table('course_evaluation_type', function (Blueprint $table): void {
            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onDelete('cascade');

            $table->foreign('evaluation_type_id')
                ->references('id')->on('evaluation_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('evaluation_types');
        Schema::dropIfExists('course_evaluation_type');
    }
}
