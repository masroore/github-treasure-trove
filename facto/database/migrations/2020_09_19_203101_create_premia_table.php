<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePremiaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('premia', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('upso_id');
            $table->bigInteger('upso_type_id')->nullable();
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->string('file_name')->nullable();
            $table->string('status')->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('premia');
    }
}
