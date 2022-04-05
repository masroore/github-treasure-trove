<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('campus_id')->unsigned()->default(1);
            $table->integer('capacity')->nullable()->unsigned();
            $table->softDeletes();
        });

        Schema::table('courses', function (Blueprint $table): void {
            $table->foreign('room_id')
                ->references('id')->on('rooms')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('rooms');
    }
}
