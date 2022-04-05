<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSanitationsTable extends Migration
{
    public function up(): void
    {
        Schema::table('sanitations', function (Blueprint $table): void {
            $table->unsignedBigInteger('kecamatan_id');
            $table->foreign('kecamatan_id', 'kecamatan_fk_5273604')->references('id')->on('kecamatans');
        });
    }
}
