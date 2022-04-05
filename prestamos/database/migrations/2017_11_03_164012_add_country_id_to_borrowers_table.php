<?php

use Illuminate\Database\Migrations\Migration;

class AddCountryIdToBorrowersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('borrowers', function ($table): void {
            $table->dropColumn('country');
            $table->integer('country_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
}
