<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCustomerUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customer_users', function (Blueprint $table): void {
            $table->enum('gender', ['male', 'female'])->default(null)->nullable()->after('password');
            $table->date('date_of_birth')->default(null)->nullable()->after('password');
            $table->string('company_name')->default(null)->nullable()->after('password');
            $table->boolean('subscribe')->default(0)->comment('1 => Active 0 => Inactive')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_users', function (Blueprint $table): void {
            $table->dropColumn('gender');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('company_name');
            $table->dropColumn('subscribe');
        });
    }
}
