<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColTagsCampanias extends Migration
{
    public function up(): void
    {
        Schema::table('campanias', function (Blueprint $table): void {
            $table->string('tags')->default('');
        });
    }

    public function down(): void
    {
    }
}
