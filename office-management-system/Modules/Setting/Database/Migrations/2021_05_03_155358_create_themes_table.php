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
            $table->string('title')->nullable();
            $table->string('color_mode')->default('gradient');
            $table->string('background_type')->default('image');
            $table->string('background_color')->default('#fffff');
            $table->string('background_image')->default('/public/backEnd/img/body-bg.jpg');
            $table->boolean('is_default')->default(false);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });

        $sql = [
            ['title' => 'Default Theme', 'color_mode' => 'gradient', 'background_type' => 'image', 'background_image' => asset('/public/backEnd/img/body-bg.jpg'),
                'is_default' => 1, 'created_by' => 1, ],
        ];
        DB::table('themes')->insert($sql);

        $sql = [

            // settings
            ['id' => 900, 'module_id' => 5, 'parent_id' => null, 'name' => 'Styles', 'route' => 'style.index', 'type' => 1],
            ['id' => 901, 'module_id' => 5, 'parent_id' => 900, 'name' => 'Guest Background', 'route' => 'guest-background', 'type' => 2],
            ['id' => 902, 'module_id' => 5, 'parent_id' => 900, 'name' => 'Theme Options', 'route' => 'themes.index', 'type' => 2],
            ['id' => 903, 'module_id' => 2, 'parent_id' => 902, 'name' => 'Theme Add', 'route' => 'themes.store', 'type' => 3],
            ['id' => 904, 'module_id' => 2, 'parent_id' => 902, 'name' => 'Theme Edit', 'route' => 'themes.edit', 'type' => 3],
            ['id' => 905, 'module_id' => 2, 'parent_id' => 902, 'name' => 'Theme Delete', 'route' => 'themes.delete', 'type' => 3],
            ['id' => 906, 'module_id' => 2, 'parent_id' => 902, 'name' => 'Theme Show', 'route' => 'themes.show', 'type' => 3],
            ['id' => 907, 'module_id' => 2, 'parent_id' => 902, 'name' => 'Theme Clone', 'route' => 'themes.copy', 'type' => 3],
            ['id' => 908, 'module_id' => 2, 'parent_id' => 902, 'name' => 'Make Default', 'route' => 'themes.default', 'type' => 3],

            ['id' => 726, 'module_id' => 5, 'parent_id' => 66, 'name' => 'Remove Logo / Fav', 'route' => 'setting.remove', 'type' => 2],

        ];

        DB::table('permissions')->insert($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
}
