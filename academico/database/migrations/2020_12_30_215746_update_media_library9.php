<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMediaLibrary9 extends Migration
{
    public function up(): void
    {
        Schema::table('media', function (Blueprint $table): void {
            $table->json('generated_conversions')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('media', function (Blueprint $table): void {

        });
    }
}
