<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('favorites', function (Blueprint $table): void {
            $table->integer('favorite_id');
            $table->string('favorite_type');
            $table->dropForeign('favorites_post_id_foreign');
            $table->dropColumn('post_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favorites', function (Blueprint $table): void {
            $table->dropColumn('favorite_id');
            $table->dropColumn('favorite_type');

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }
}
