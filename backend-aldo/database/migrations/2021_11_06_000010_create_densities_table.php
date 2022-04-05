<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDensitiesTable extends Migration
{
    public function up(): void
    {
        Schema::create('densities', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->float('area', 4, 2);
            $table->integer('population');
            $table->integer('density');
            $table->string('year');
            $table->timestamps();
        });
    }
}
