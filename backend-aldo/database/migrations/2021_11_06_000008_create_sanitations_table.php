<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanitationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('sanitations', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('year')->nullable();
            $table->integer('secure');
            $table->integer('basic');
            $table->integer('poor');
            $table->timestamps();
        });
    }
}
