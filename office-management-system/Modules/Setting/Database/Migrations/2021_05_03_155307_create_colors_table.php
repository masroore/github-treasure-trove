<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('colors', function (Blueprint $table): void {
            $table->id();

            $table->string('name')->nullable();
            $table->string('default_value')->nullable();

            $table->timestamps();
        });

        $sql = [
            ['name' => 'base_color', 'default_value' => '#415094'],
            ['name' => 'gradient_1', 'default_value' => '#7c32ff'],
            ['name' => 'gradient_2', 'default_value' => '#A235EC'],
            ['name' => 'gradient_3', 'default_value' => '#c738d8'],

            ['name' => 'scroll_color', 'default_value' => '#7e7172'],
            ['name' => 'text-color', 'default_value' => '#828bb2'],
            ['name' => 'text_white', 'default_value' => '#ffffff'],
            ['name' => 'bg_white', 'default_value' => '#ffffff'],
            ['name' => 'text_black', 'default_value' => '#000000'],
            ['name' => 'bg_black', 'default_value' => '#000000'],
            ['name' => 'border_color', 'default_value' => '#ECEEF4'],
            ['name' => 'input__bg', 'default_value' => '#ffffff'],

            ['name' => 'success', 'default_value' => '#51A351'],
            ['name' => 'warning', 'default_value' => '#E09079'],
            ['name' => 'danger', 'default_value' => '#FF6D68'],

        ];

        DB::table('colors')->insert($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colors');
    }
}
