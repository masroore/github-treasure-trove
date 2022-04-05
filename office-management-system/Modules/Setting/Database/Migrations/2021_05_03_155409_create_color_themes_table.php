<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorThemesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('color_theme', function (Blueprint $table): void {
            $table->foreignId('color_id')->nullable();
            $table->foreign('color_id')->on('colors')->references('id')->onDelete('cascade');

            $table->foreignId('theme_id')->nullable();
            $table->foreign('theme_id')->on('themes')->references('id')->onDelete('cascade');

            $table->string('value')->nullable();
        });

        $sql = [
            ['theme_id' => 1, 'color_id' => 1, 'value' => '#415094'],
            ['theme_id' => 1, 'color_id' => 2, 'value' => '#7c32ff'],
            ['theme_id' => 1, 'color_id' => 3, 'value' => '#A235EC'],
            ['theme_id' => 1, 'color_id' => 4, 'value' => '#c738d8'],
            ['theme_id' => 1, 'color_id' => 5, 'value' => '#7e7172'],
            ['theme_id' => 1, 'color_id' => 6, 'value' => '#828bb2'],
            ['theme_id' => 1, 'color_id' => 7, 'value' => '#ffffff'],
            ['theme_id' => 1, 'color_id' => 8, 'value' => '#ffffff'],
            ['theme_id' => 1, 'color_id' => 9, 'value' => '#000000'],
            ['theme_id' => 1, 'color_id' => 10, 'value' => '#000000'],
            ['theme_id' => 1, 'color_id' => 11, 'value' => '#ECEEF4'],
            ['theme_id' => 1, 'color_id' => 12, 'value' => '#ffffff'],
            ['theme_id' => 1, 'color_id' => 13, 'value' => '#51A351'],
            ['theme_id' => 1, 'color_id' => 14, 'value' => '#E09079'],
            ['theme_id' => 1, 'color_id' => 15, 'value' => '#FF6D68'],
        ];
        DB::table('color_theme')->insert($sql);
    }

    /**
     * Reverse the migrations.y.
     */
    public function down(): void
    {
        Schema::table('color_theme', function (Blueprint $table): void {
            $table->dropForeign('color_theme_color_id_foreign');
            $table->dropForeign('color_theme_theme_id_foreign');
        });
        Schema::dropIfExists('color_theme');
    }
}
