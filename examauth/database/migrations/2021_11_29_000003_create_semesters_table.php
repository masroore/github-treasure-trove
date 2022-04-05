<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemestersTable extends Migration
{
    public function up(): void
    {
        Schema::create('semesters', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('semester')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
