<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'trainings',
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->integer('branch');
                $table->integer('trainer_option');
                $table->integer('training_type');
                $table->integer('trainer');
                $table->float('training_cost')->default(0.00);
                $table->integer('employee');
                $table->date('start_date');
                $table->date('end_date');
                $table->text('description')->nullable();
                $table->integer('performance')->default(0);
                $table->integer('status')->default(0);
                $table->text('remarks')->nullable();
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
        Schema::dropIfExists('trainings');
    }
}
