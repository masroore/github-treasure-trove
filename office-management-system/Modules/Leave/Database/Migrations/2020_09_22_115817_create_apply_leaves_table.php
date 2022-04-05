<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplyLeavesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('apply_leaves', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('leave_type_id');
            $table->text('reason');
            $table->string('attachment', 255)->nullable();
            $table->date('apply_date');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('day');
            $table->boolean('makeup_leave')->default(0);
            $table->date('makeup_date')->nullable();
            $table->boolean('makeup_half')->default(0);
            $table->boolean('leave_from')->default(0);
            $table->boolean('leave_to')->default(0);
            $table->double('total_days')->default(0);
            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apply_leaves');
    }
}
