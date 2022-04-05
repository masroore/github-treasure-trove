<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFcodeToApplicationinfosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('applicationinfos', function (Blueprint $table): void {
            $table->string('fcode')->nullable();
            $table->string('scode')->nullable();
            $table->string('tcode')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('applicationinfos', 'fcode')) {
            Schema::table('applicationinfos', function (Blueprint $table): void {
                $table->dropColumn('fcode');
            });
        }

        if (Schema::hasColumn('applicationinfos', 'scode')) {
            Schema::table('applicationinfos', function (Blueprint $table): void {
                $table->dropColumn('scode');
            });
        }

        if (Schema::hasColumn('applicationinfos', 'tcode')) {
            Schema::table('applicationinfos', function (Blueprint $table): void {
                $table->dropColumn('tcode');
            });
        }
    }
}
