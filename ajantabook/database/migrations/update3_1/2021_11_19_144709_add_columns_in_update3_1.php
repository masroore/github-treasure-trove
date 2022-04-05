<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('simple_products', function (Blueprint $table): void {
            if (Schema::hasColumn('simple_products', 'offer_price')) {
                $table->float('offer_price')->default(0)->change();
            }
        });

        Schema::table('users', function (Blueprint $table): void {
            if (Schema::hasColumn('users', 'stripe_id')) {
                $table->string('stripe_id')->nullable();
            }
        });
    }
};
