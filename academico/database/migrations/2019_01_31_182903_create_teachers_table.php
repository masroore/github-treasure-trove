<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table): void {
            //$table->increments('id');
            $table->integer('id')->unsigned()->unique();
            $table->timestamp('hired_at')->nullable();
            $table->decimal('max_week_hours', 4, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('courses', function (Blueprint $table): void {
            $table->foreign('teacher_id')
                ->references('id')->on('teachers')
                ->onDelete('restrict');
        });

        Schema::table('remote_events', function (Blueprint $table): void {
            $table->foreign('teacher_id')
                ->references('id')->on('teachers')
                ->onDelete('cascade');
        });

        Schema::table('leaves', function (Blueprint $table): void {
            $table->foreign('teacher_id')
                ->references('id')->on('teachers')
                ->onDelete('cascade');
        });

        Schema::table('events', function (Blueprint $table): void {
            $table->foreign('teacher_id')
                ->references('id')->on('teachers')
                ->onDelete('restrict');
        });

        Schema::table('teachers', function (Blueprint $table): void {
            $table->foreign('id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('teachers');
    }
}
