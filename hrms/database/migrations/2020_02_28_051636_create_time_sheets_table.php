<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeSheetsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'time_sheets',
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->integer('employee_id')->default(0);
                $table->date('date');
                $table->float('hours')->default(0.0);
                $table->text('remark')->nullable();
                $table->integer('created_by')->default('0');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_sheets');
    }
}
