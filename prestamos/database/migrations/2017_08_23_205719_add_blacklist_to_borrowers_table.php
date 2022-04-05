<?php

use Illuminate\Database\Migrations\Migration;

class AddBlacklistToBorrowersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('borrowers', function ($table): void {
            $table->tinyInteger('blacklisted')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowers', function ($table): void {
            $table->dropColumn([
                'blacklisted',
            ]);
        });
    }
}
