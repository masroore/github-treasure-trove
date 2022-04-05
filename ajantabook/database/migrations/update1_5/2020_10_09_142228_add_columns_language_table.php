<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsLanguageTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('locales')) {
            Schema::table('locales', function (Blueprint $table): void {
                if (!Schema::hasColumn('locales', 'rtl_available')) {
                    $table->integer('rtl_available')->default(0)->unsigned();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locales', function (Blueprint $table): void {
            $table->dropColumn('rtl_available');
        });
    }
}
