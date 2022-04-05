<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('menus')) {
            Schema::create('menus', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('title');
                $table->string('icon')->nullable();
                $table->string('link_by');
                $table->integer('cat_id')->unsigned()->nullable();
                $table->integer('page_id')->unsigned()->nullable();
                $table->string('url')->nullable();
                $table->integer('position')->unsigned();
                $table->integer('show_cat_in_dropdown')->default(0)->unsigned();
                $table->longtext('linked_parent')->nullable();
                $table->integer('show_child_in_dropdown')->default(0)->unsigned();
                $table->longtext('linked_child')->nullable();
                $table->string('bannerimage')->nullable();
                $table->string('img_link')->nullable();
                $table->integer('menu_tag')->unsigned()->default(0);
                $table->string('tag_bg')->nullable();
                $table->string('tag_color')->nullable();
                $table->string('tag_text')->nullable();
                $table->integer('show_image')->unsigned()->default(0);
                $table->integer('status')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('menus');
    }
}
