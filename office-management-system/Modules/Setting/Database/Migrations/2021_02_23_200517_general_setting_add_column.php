<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class GeneralSettingAddColumn extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('general_settings', function ($table): void {
            if (!Schema::hasColumn('general_settings', 'last_updated_date')) {
                $table->string('last_updated_date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_settings', function ($table): void {
            $table->dropColumn('system_domain');
            $table->dropColumn('system_activated_date');
            $table->dropColumn('last_updated_date');
        });
    }
}
