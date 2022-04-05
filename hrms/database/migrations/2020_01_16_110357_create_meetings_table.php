<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'meetings',
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->integer('branch_id');
                $table->longText('department_id');
                $table->longText('employee_id');
                $table->string('title');
                $table->date('date');
                $table->time('time');
                $table->text('note')->nullable();
                $table->integer('created_by');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
}
