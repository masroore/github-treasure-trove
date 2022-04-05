<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBuildGalleriesTable extends Migration
{
    public function up(): void
    {
        Schema::table('build_galleries', function (Blueprint $table): void {
            $table->unsignedBigInteger('build_id')->nullable();
            $table->foreign('build_id', 'build_fk_5267080')->references('id')->on('builds');
        });
    }
}
