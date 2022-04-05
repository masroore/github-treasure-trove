<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultColumnToFees extends Migration
{
    public function up(): void
    {
        Schema::table('fees', function (Blueprint $table): void {
            $table->boolean('default')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('fees', function (Blueprint $table): void {

        });
    }
}
