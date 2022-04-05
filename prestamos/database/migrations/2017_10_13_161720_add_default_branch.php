<?php

use Illuminate\Database\Migrations\Migration;

class AddDefaultBranch extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('branches', function ($table): void {
            $table->tinyInteger('default_branch')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branches', function ($table): void {
            $table->dropColumn([
                'default_branch',
            ]);
        });
    }
}
