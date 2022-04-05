<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('levels', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('name')->unique();
            $table->softDeletes();
        });

        Schema::table('courses', function (Blueprint $table): void {
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
        Schema::dropIfExists('levels');
    }
}
