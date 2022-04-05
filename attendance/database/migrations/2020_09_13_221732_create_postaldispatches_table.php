<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostaldispatchesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('postaldispatches', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('to')->nullable();
            $table->string('ref')->nullable();
            $table->string('address')->nullable();
            $table->string('from')->nullable();
            $table->string('docdate')->nullable();
            $table->string('doc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postaldispatches');
    }
}
