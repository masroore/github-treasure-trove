<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleToStudentinfosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('studentinfos', function (Blueprint $table): void {
            $table->string('title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('studentinfos', 'title')) {
            Schema::table('studentinfos', function (Blueprint $table): void {
                $table->dropColumn('title');
            });
        }
    }
}
