<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleToPersonalinfosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('personalinfos', function (Blueprint $table): void {
            $table->string('title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('personalinfos', 'title')) {
            Schema::table('personalinfos', function (Blueprint $table): void {
                $table->dropColumn('title');
            });
        }
    }
}
