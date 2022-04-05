<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBuildsTable extends Migration
{
    public function up(): void
    {
        Schema::table('builds', function (Blueprint $table): void {
            $table->unsignedBigInteger('categories_id');
            $table->foreign('categories_id', 'categories_fk_5266953')->references('id')->on('categories');
            $table->unsignedBigInteger('kecamatans_id');
            $table->foreign('kecamatans_id', 'kecamatans_fk_5266951')->references('id')->on('kecamatans');
            $table->unsignedBigInteger('kelurahans_id');
            $table->foreign('kelurahans_id', 'kelurahans_fk_5266952')->references('id')->on('kelurahans');
        });
    }
}
