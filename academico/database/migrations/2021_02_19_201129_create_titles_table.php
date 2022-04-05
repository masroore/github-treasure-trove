<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTitlesTable extends Migration
{
    public function up(): void
    {
        Schema::create('titles', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('title')->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('titles');
    }
}
