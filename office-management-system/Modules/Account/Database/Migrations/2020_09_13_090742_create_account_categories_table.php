<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAccountCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 150);
            $table->timestamps();
        });
        $sql = [
            ['name' => 'Account for Cash'],
            ['name' => 'Account for Bank'],
            ['name' => 'Account for receivable'],
            ['name' => 'Account for Payable'],
            ['name' => 'Account for Equity/Capital'],
        ];
        DB::table('account_categories')->insert($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_categories');
    }
}
