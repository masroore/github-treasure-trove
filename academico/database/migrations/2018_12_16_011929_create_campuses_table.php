<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampusesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campuses', function (Blueprint $table): void {
            $table->increments('id');
            $table->text('name');
            $table->softDeletes();
        });

        Schema::table('courses', function (Blueprint $table): void {
            $table->foreign('campus_id')
                ->references('id')->on('campuses')
                ->onDelete('restrict');
        });

        Schema::table('rooms', function (Blueprint $table): void {
            $table->foreign('campus_id')
                ->references('id')->on('campuses')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('campuses');
    }
}
