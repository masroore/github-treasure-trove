<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildsTable extends Migration
{
    public function up(): void
    {
        Schema::create('builds', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('address');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('year')->nullable();
            $table->string('status')->nullable();
            $table->string('funded')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
