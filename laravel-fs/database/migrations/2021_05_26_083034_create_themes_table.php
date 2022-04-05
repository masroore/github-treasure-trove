<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThemesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table): void {
            $table->id();
            $table->string('description', 200);
            $table->string('class_name', 20);
        });
        DB::table('themes')->insert([
            [
                'description' => 'Light',
                'class_name' => 'light-theme',
            ],
            [
                'description' => 'Dark',
                'class_name' => 'dark-theme',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
}
