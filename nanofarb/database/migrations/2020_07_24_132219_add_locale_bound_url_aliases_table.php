<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocaleBoundUrlAliasesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('url_aliases', function (Blueprint $table): void {
            $table->string('locale_bound')->nullable()->after('model_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('url_aliases', function (Blueprint $table): void {
            $table->dropColumn('locale_bound');
        });
    }
}
