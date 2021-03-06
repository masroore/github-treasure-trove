<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('osncode_id')->nullable();
            $table->string('name')->nullable();
            $table->string('schstart')->nullable();
            $table->string('schend')->nullable();
            $table->string('name2')->nullable();
            $table->string('schstart2')->nullable();
            $table->string('schend2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
}
