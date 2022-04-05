<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStylingToSkillScalesTable extends Migration
{
    public function up(): void
    {
        Schema::table('skill_scales', function (Blueprint $table): void {
            $table->string('classes');
        });
    }

    public function down(): void
    {
        Schema::table('skill_scales', function (Blueprint $table): void {

        });
    }
}
