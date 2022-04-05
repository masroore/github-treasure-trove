<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCustomerUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customer_users', function (Blueprint $table): void {
            $table->string('token')->default(null)->nullbale()->after('password');
            $table->string('password_reset_at')->default(null)->nullbale()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_users', function (Blueprint $table): void {
            $table->dropColumn('token');
            $table->dropColumn('password_reset_at');
        });
    }
}
