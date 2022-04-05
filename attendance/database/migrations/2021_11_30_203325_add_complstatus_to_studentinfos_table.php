<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddComplstatusToStudentinfosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('studentinfos', function (Blueprint $table): void {
            $table->string('completstatus')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('studentinfos', 'completstatus')) {
            Schema::table('studentinfos', function (Blueprint $table): void {
                $table->dropColumn('completstatus');
            });
        }
    }
}
