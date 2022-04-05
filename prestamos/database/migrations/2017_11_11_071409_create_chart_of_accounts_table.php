<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChartOfAccountsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chart_of_accounts', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->text('name')->nullable();
            $table->integer('gl_code')->nullable();
            $table->enum('account_type', ['asset', 'expense', 'equity', 'liability', 'income'])->default('asset');
            $table->tinyInteger('allow_manual')->default(0);
            $table->tinyInteger('active')->default(1);
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('chart_of_accounts');
    }
}
