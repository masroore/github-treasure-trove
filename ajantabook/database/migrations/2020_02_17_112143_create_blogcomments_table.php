<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogcommentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('blogcomments')) {
            Schema::create('blogcomments', function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('post_id')->unsigned();
                $table->string('name', 191);
                $table->string('email', 191);
                $table->text('comment', 65535);
                $table->integer('status')->unsigned()->default(1);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('blogcomments');
    }
}
