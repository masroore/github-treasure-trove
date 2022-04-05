<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medios', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('tipo_medio')->default('');
            $table->string('alcance')->default('');
            $table->string('url')->default('');
            $table->string('nombre')->default('');
            $table->string('imagen')->default('');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medios');
    }
}
