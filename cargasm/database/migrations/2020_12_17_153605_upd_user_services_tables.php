<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdUserServicesTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('status')
                ->default(\App\Models\User::STATUS_APPROVED)
                ->after('active');
            $table->text('msg_reject')->nullable()->after('status');
            $table->dropColumn('active');
        });

        Schema::table('services', function (Blueprint $table): void {
            $table->boolean('is_active')->after('status')->default(true);
            $table->boolean('is_sitemap')->after('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->boolean('active')->default(1)->after('status');
            $table->dropColumn(['status', 'msg_reject']);
        });

        Schema::table('services', function (Blueprint $table): void {
            $table->dropColumn(['is_active', 'is_sitemap']);
        });
    }
}
