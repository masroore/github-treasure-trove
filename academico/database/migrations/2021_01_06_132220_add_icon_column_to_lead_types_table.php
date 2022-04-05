<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIconColumnToLeadTypesTable extends Migration
{
    public function up(): void
    {
        Schema::table('lead_types', function (Blueprint $table): void {
            $table->string('icon')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('lead_types', function (Blueprint $table): void {
            $table->dropColumn('icon');
        });
    }
}
