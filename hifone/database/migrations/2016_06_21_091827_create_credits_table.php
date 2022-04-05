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

class CreateCreditsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('credits', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('rule_id');
            $table->integer('balance');
            $table->string('frequency_tag')->nullable();
            $table->text('body')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('rule_id');
            $table->index('frequency_tag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('credits');
    }
}
