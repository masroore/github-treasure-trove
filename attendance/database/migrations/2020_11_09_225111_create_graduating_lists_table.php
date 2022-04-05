<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGraduatingListsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('graduating_lists', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('type')->nullable();
            $table->string('programme')->nullable();
            $table->string('session')->nullable();
            $table->string('academicyear')->nullable();
            $table->string('fullname')->nullable();
            $table->string('gpa')->nullable();
            $table->string('graduatingclas')->nullable();
            $table->string('year')->nullable();
            $table->string('level')->nullable();
            $table->string('indexnumber')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graduating_lists');
    }
}
