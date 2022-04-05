<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteColCampaniaId extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('busquedas', function (Blueprint $table): void {
            $table->dropForeign(['campania_id']);
            $table->dropColumn('campania_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
}
