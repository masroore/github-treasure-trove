<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSizeChartsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('size_charts')) {
            Schema::create('size_charts', function (Blueprint $table): void {
                $table->id();
                $table->string('template_name');
                $table->char('template_code', 36);
                $table->integer('user_id')->unsigned();
                $table->integer('status')->unsigned()->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('size_charts');
    }
}
