<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admin_users', function (Blueprint $table): void {
            $table->dropColumn('name');
            $table->string('username')->nullable()->after('id')->default(null);
            $table->string('first_name')->nullable()->after('username')->default(null);
            $table->string('middle_name')->nullable()->after('first_name')->default(null);
            $table->string('last_name')->nullable()->after('middle_name')->default(null);
            $table->string('contact')->nullable()->after('middle_name')->default(null);
            $table->string('status')->nullable()->after('remember_token')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_users', function (Blueprint $table): void {
            $table->string('name')->nullable()->default(null);
            $table->dropColumn('username');
            $table->dropColumn('first_name');
            $table->dropColumn('middle_name');
            $table->dropColumn('last_name');
            $table->dropColumn('status');
        });
    }
}
