<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoalTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'goal_trackings',
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->integer('branch');
                $table->integer('goal_type');
                $table->date('start_date');
                $table->date('end_date');
                $table->string('subject')->nullable();
                $table->string('target_achievement')->nullable();
                $table->text('description')->nullable();
                $table->integer('status')->default(0);
                $table->integer('progress')->default(0);
                $table->integer('created_by')->default(0);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_trackings');
    }
}
