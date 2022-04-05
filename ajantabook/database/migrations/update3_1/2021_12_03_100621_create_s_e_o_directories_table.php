<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSEODirectoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('s_e_o_directories')) {
            Schema::create('s_e_o_directories', function (Blueprint $table): void {
                $table->id();
                $table->string('city');
                $table->longText('detail');
                $table->integer('status')->unsigned()->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_e_o_directories');
    }
}
