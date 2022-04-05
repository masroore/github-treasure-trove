<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leave_types', function (Blueprint $table): void {
            $table->increments('id');
            $table->text('name');
        });

        Schema::create('leaves', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('teacher_id')->unsigned();
            $table->date('date');
            $table->integer('leave_type_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('leaves', function (Blueprint $table): void {
            $table->foreign('leave_type_id')
                ->references('id')->on('leave_types')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('leave_types');
        Schema::dropIfExists('leaves');
    }
}
