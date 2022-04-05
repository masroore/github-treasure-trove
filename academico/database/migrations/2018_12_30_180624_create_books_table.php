<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('name');
            $table->bigInteger('price')->nullable();
            //$table->timestamps();
        });

        Schema::create('book_course', function (Blueprint $table): void {
            $table->integer('book_id')->unsigned();
            $table->integer('course_id')->unsigned();
            $table->index(['book_id', 'course_id']);
        });

        Schema::table('book_course', function (Blueprint $table): void {
            $table->foreign('book_id')
                ->references('id')->on('books')
                ->onDelete('restrict');
        });

        Schema::table('book_course', function (Blueprint $table): void {
            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('books');
        Schema::dropIfExists('book_course');
    }
}
