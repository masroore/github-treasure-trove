<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKecamatansTable extends Migration
{
    public function up(): void
    {
        Schema::create('kecamatans', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('color');
            $table->longText('geojson')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
