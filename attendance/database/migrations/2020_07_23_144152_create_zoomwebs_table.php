<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoomwebsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('zoomwebs', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('zoomid');
            $table->string('user_id');
            $table->string('uuid');
            $table->string('lec_id');
            $table->string('lec_name');
            $table->string('title');
            $table->string('starttime');
            $table->string('duration');
            $table->string('level');
            $table->string('session');
            $table->string('programme');
            $table->string('cousers');
            $table->string('join_url');
            $table->string('start_url');
            $table->string('academicyear');
            $table->string('semester');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoomwebs');
    }
}
