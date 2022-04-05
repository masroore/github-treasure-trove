<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTaskTagPivotTable extends Migration
{
    public function up(): void
    {
        Schema::create('task_task_tag', function (Blueprint $table): void {
            $table->unsignedBigInteger('task_id');
            $table->foreign('task_id', 'task_id_fk_5276282')->references('id')->on('tasks')->onDelete('cascade');
            $table->unsignedBigInteger('task_tag_id');
            $table->foreign('task_tag_id', 'task_tag_id_fk_5276282')->references('id')->on('task_tags')->onDelete('cascade');
        });
    }
}
