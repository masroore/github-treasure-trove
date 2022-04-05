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

class CreateStatsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stats', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('day');
            $table->integer('register_count')->default(0);
            $table->integer('thread_count')->default(0);
            $table->integer('reply_count')->default(0);
            $table->integer('image_count')->default(0);
            $table->timestamps();

            $table->index('day');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('stats');
    }
}
