<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the Anonymous migrations.
     */
    public function up(): void
    {
        Schema::table('hotdeals', function (Blueprint $table): void {
            if (!Schema::hasColumn('hotdeals', 'simple_pro_id')) {
                $table->integer('simple_pro_id')->default(0);
            }
        });

        Schema::table('special_offers', function (Blueprint $table): void {
            if (!Schema::hasColumn('special_offers', 'simple_pro_id')) {
                $table->integer('simple_pro_id')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
