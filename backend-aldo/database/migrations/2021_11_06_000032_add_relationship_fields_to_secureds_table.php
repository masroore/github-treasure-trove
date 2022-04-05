<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSecuredsTable extends Migration
{
    public function up(): void
    {
        Schema::table('secureds', function (Blueprint $table): void {
            $table->unsignedBigInteger('kecamatan_id');
            $table->foreign('kecamatan_id', 'kecamatan_fk_5274240')->references('id')->on('kecamatans');
            $table->unsignedBigInteger('access_id');
            $table->foreign('access_id', 'access_fk_5274241')->references('id')->on('sanitations');
        });
    }
}
