<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetInfoTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('set_infos', function (Blueprint $table): void {
            $table->unsignedInteger('set_id');
            $table->unsignedInteger('set_info_id');
            $table->string('set_info_type');
            $table->unique(['set_id', 'set_info_id', 'set_info_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set_info');
    }
}
