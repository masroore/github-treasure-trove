<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlog extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blog', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('title');
            $table->string('poster_intro');
            $table->mediumText('intro');
            $table->string('poster_image');
            $table->string('detail_image');
            $table->dateTime('date_to_publish')->useCurrent();
            $table->dateTime('date_to_expire')->default(null)->nullable();
            $table->tinyInteger('status')->default(0)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog');
    }
}
