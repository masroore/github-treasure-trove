<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table): void {
            $table->increments('id');
            $table->text('name');
            $table->integer('default_weight')->default(1);
            $table->integer('level_id')->unsigned();
            $table->integer('skill_type_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('skills', function (Blueprint $table): void {
            $table->foreign('level_id')
                ->references('id')->on('levels')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('skills');
    }
}
