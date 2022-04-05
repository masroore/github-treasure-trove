<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutusesTable extends Migration
{
    public function up(): void
    {
        Schema::create('aboutuses', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->longText('description');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
