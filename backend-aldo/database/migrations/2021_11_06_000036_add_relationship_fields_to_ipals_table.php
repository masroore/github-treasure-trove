<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToIpalsTable extends Migration
{
    public function up(): void
    {
        Schema::table('ipals', function (Blueprint $table): void {
            $table->unsignedBigInteger('kelurahans_id');
            $table->foreign('kelurahans_id', 'kelurahans_fk_5267063')->references('id')->on('kelurahans');
            $table->unsignedBigInteger('categories_id');
            $table->foreign('categories_id', 'categories_fk_5267069')->references('id')->on('categories');
        });
    }
}
