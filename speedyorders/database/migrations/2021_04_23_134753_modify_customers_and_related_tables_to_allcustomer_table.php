<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomersAndRelatedTablesToAllcustomerTable extends Migration
{
    public function up(): void
    {
        Schema::table('customer_users', function (Blueprint $table): void {
            $table->dropColumn('username');
            $table->dropColumn('first_name');
            $table->dropColumn('middle_name');
            $table->dropColumn('last_name');
            $table->dropColumn('subscribe');
            $table->dropColumn('company_name');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('gender');
            $table->dropColumn('contact');
            $table->dropColumn('phone');
        });

        Schema::table('customers', function (Blueprint $table): void {
            $table->dropColumn('email');
            $table->dropColumn('postal_code');
            $table->dropColumn('address2');
            $table->dropColumn('address1');
            $table->date('date_of_birth')->default(null)->nullable()->after('last_name');
        });

        Schema::table('customer_addresses', function (Blueprint $table): void {
            $table->dropColumn('c_first_name');
            $table->dropColumn('c_last_name');
            $table->dropColumn('c_telephone');
        });
    }

    public function down(): void
    {
        Schema::table('customer_users', function (Blueprint $table): void {
            $table->string('username')->default(null)->nullable();
            $table->string('first_name')->default(null)->nullable();
            $table->string('middle_name')->default(null)->nullable();
            $table->string('last_name')->default(null)->nullable();
            $table->enum('gender', ['male', 'female'])->default(null)->nullable()->after('password');
            $table->date('date_of_birth')->default(null)->nullable()->after('password');
            $table->string('company_name')->default(null)->nullable()->after('password');
            $table->boolean('subscribe')->default(0)->comment('1 => Active 0 => Inactive')->nullable()->after('password');
            $table->string('contact')->default(null)->nullable();
            $table->string('phone')->default(null)->nullable();
        });

        Schema::table('customers', function (Blueprint $table): void {
            $table->string('email')->default(null)->nullable();
            $table->string('postal_code')->default(null)->nullable();
            $table->string('address2')->default(null)->nullable();
            $table->string('address1')->default(null)->nullable();
        });

        Schema::table('customer_addresses', function (Blueprint $table): void {
            $table->string('c_first_name');
            $table->string('c_last_name');
            $table->string('c_telephone');
        });
    }
}
