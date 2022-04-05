<?php

use Illuminate\Database\Migrations\Migration;

class CreateDefaultBranchAndAssignUser extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $branch = new \App\Models\Branch();
        $branch->name = 'Default';
        $branch->default_branch = '1';
        $branch->save();
        //we made a mistake here in ver1.3 for new installation. We tried to use seeded data before seeding was run
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
}
