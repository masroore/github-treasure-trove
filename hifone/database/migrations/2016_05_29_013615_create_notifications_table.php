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

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('author_id');
            $table->integer('user_id');
            $table->integer('object_id');
            $table->string('object_type');
            $table->string('type');
            $table->text('body')->nullable();
            $table->timestamps();

            $table->index('author_id');
            $table->index('user_id');
            $table->index('object_id');
            $table->index('object_type');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('notifications');
    }
}
