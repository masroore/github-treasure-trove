<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadedtimetablesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('uploadedtimetables', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('level');
            $table->string('session');
            $table->string('type');
            $table->string('semester');
            $table->string('academicyear');
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploadedtimetables');
    }
}
