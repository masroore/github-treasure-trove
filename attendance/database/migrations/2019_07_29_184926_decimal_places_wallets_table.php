<?php

use Bavix\Wallet\Models\Wallet;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DecimalPlacesWalletsTable extends Migration
{
    public function up(): void
    {
        Schema::table($this->table(), function (Blueprint $table) {
            $table->smallInteger('decimal_places')
                ->default(2)
                ->after('balance');
        });
    }

    public function down(): void
    {
        Schema::table($this->table(), function (Blueprint $table) {
            $table->dropColumn('decimal_places');
        });
    }

    protected function table(): string
    {
        return (new Wallet())->getTable();
    }
}
