<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('managers', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('upso_id');
            $table->string('name');
            $table->integer('price');
            $table->integer('age');
            $table->integer('ht');
            $table->integer('wt');
            $table->string('bsize');
            $table->string('cc');
            $table->text('content')->nullable();
            $table->integer('visits')->default(0);
            $table->string('thumb_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managers');
    }
}
