<?php

/*
 * This file is part of Hifone.
 *
 * (c) Hifone.com <hifone@hifone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePmsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pms', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('root_id', 10);
            $table->integer('user_id');
            $table->integer('author_id');
            $table->tinyInteger('folder');
            $table->integer('meta_id');
            $table->timestamps();

            $table->index('user_id');
            $table->index('root_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('pms');
    }
}
