<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInCustomerAddressTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customer_addresses', function (Blueprint $table): void {
            if (!Schema::hasColumn('customer_addresses', 'a_first_name')) {
                $table->string('a_first_name', 255)->default(null)->nullable()->after('customer_user_id');
            }
            if (!Schema::hasColumn('customer_addresses', 'a_last_name')) {
                $table->string('a_last_name', 255)->default(null)->nullable()->after('a_first_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_addresses', function (Blueprint $table): void {
        });
    }
}
