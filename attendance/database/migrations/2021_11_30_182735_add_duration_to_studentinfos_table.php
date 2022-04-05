<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDurationToStudentinfosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('studentinfos', function (Blueprint $table): void {
            $table->string('duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('studentinfos', 'duration')) {
            Schema::table('studentinfos', function (Blueprint $table): void {
                $table->dropColumn('duration');
            });
        }
    }
}
