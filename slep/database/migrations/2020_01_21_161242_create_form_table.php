<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('form', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name');
            $table->string('table_name');
            $table->boolean('read');
            $table->boolean('edit');
            $table->boolean('add');
            $table->boolean('delete');
            $table->integer('pagination');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form');
    }
}
