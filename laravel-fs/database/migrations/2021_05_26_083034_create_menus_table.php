<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table): void {
            $table->id();
            $table->string('name_menu', 50);
            $table->string('description', 200);
            $table->string('icon', 50);
            $table->integer('order');
        });
        DB::table('menus')->insert([
            [
                'name_menu' => 'Administration',
                'description' => 'Administration of System',
                'icon' => 'fa-folder',
                'order' => 1,
            ],
            [
                'name_menu' => 'Maintenance',
                'description' => 'Maintenance of System',
                'icon' => 'fa-cogs',
                'order' => 2,
            ],
            [
                'name_menu' => 'Acquisition',
                'description' => 'Register of Acquisition',
                'icon' => 'fa-building',
                'order' => 3,
            ],
            [
                'name_menu' => 'Inventory',
                'description' => 'Manage Inventory',
                'icon' => 'fa-boxes',
                'order' => 4,
            ],
            [
                'name_menu' => 'Clients',
                'description' => 'Manage Clients',
                'icon' => 'fa-users',
                'order' => 5,
            ],
            [
                'name_menu' => 'Consult',
                'description' => 'Consult',
                'icon' => 'fa-clipboard-list',
                'order' => 6,
            ],
            [
                'name_menu' => 'Mastercard',
                'description' => 'Registration and Control Mastercard',
                'icon' => 'fa-credit-card',
                'order' => 7,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
}
