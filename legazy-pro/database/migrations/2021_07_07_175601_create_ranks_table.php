<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRanksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ranks', function (Blueprint $table): void {
            $table->bigIncrements('id')->unsigned();
            $table->string('name');
            $table->longtext('description');
            $table->longtext('points');
            $table->enum('status', [0, 1])->default(0)->comment('0 - Activo, 1 - Inactivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ranks');
    }
}
