<?php

use Illuminate\Database\Migrations\Migration;

class AddLoginFieldsToBorrowersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('borrowers', function ($table): void {
            $table->string('username')->nullable();
            $table->string('password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowers', function ($table): void {
            $table->dropColumn([
                'username',
                'password',
            ]);
        });
    }
}
