<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRhythmsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rhythms', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('default_volume')->nullable()->unsigned();
            $table->softDeletes();
        });

        Schema::table('courses', function (Blueprint $table): void {
            $table->foreign('rhythm_id')
                ->references('id')->on('rhythms')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('rhythms');
    }
}
