<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpalsTable extends Migration
{
    public function up(): void
    {
        Schema::create('ipals', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('address');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->float('capacity', 3, 2)->nullable();
            $table->string('year')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }
}
