<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('widget_groups', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->integer('section_id')->unsigned()->index();
            $table->string('title');
            $table->string('slug')->index();
            $table->string('width')->nullable();
            $table->boolean('status')->unsigned()->default(0);
            $table->timestamps();
        });

        Schema::create('widgets', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->integer('group_id')->unsigned()->index();
            $table->string('title')->index();
            $table->text('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->integer('link_id')->nullable();
            $table->string('url')->nullable();
            $table->string('badge')->nullable();
            $table->string('width')->nullable();
            $table->integer('sort_order')->unsigned()->default(0);
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widget_groups');
        Schema::dropIfExists('widgets');
    }

    /*
  CREATE TABLE `skladisna`.`widgets` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `group` VARCHAR(191) NOT NULL,
  `title` VARCHAR(191) NOT NULL,
  `subtitle` TEXT(1000) NULL,
  `image` VARCHAR(191) NULL,
  `link` VARCHAR(191) NULL,
  `link_id` INT(11) NULL,
  `url` VARCHAR(191) NOT NULL,
  `badge` VARCHAR(191) NULL,
  `width` VARCHAR(191) NULL,
  `sort_order` TINYINT(1) UNSIGNED NULL DEFAULT 0,
  `status` TINYINT(1) NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`));
    */
}
