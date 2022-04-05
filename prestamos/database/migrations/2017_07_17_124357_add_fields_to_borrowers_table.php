<?php

use Illuminate\Database\Migrations\Migration;

class AddFieldsToBorrowersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('borrowers', function ($table): void {
            $table->enum('source', ['online', 'admin'])->default('admin')->nullable();
            $table->tinyInteger('active')->default(1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowers', function ($table): void {
            $table->dropColumn([
                'source',
                'active',
            ]);
        });
    }
}
