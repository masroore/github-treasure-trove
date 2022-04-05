<?php

use Illuminate\Database\Migrations\Migration;

class AddLocaleColumn extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function ($table): void {
            $table->string('locale')->default(config('app.locale'));
        });

        Schema::table('contacts', function ($table): void {
            $table->string('locale')->default(config('app.locale'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function ($table): void {
            $table->dropColumn('locale');
        });

        Schema::table('contacts', function ($table): void {
            $table->dropColumn('locale');
        });
    }
}
