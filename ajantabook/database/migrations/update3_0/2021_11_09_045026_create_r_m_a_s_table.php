<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRMASTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('r_m_a_s')) {
            Schema::create('r_m_a_s', function (Blueprint $table): void {
                $table->id();
                $table->longText('reason');
                $table->integer('status')->default(0)->unsigned();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_m_a_s');
    }
}
