<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('lecturer_id');
            $table->string('lname')->nullable();
            $table->string('course_code')->nullable();
            $table->string('programme')->nullable();
            $table->string('assignment_title')->nullable();
            $table->string('assignment_description')->nullable();
            $table->string('logo')->nullable();
            $table->string('score')->nullable();
            $table->string('lecdoc')->nullable();
            $table->string('subenddate')->nullable();
            $table->string('semester')->nullable();
            $table->string('academicyear')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
}
