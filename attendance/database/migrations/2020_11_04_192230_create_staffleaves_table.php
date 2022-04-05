<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffleavesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staffleaves', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('staffid')->nullable();
            $table->string('role')->nullable();
            $table->string('applydate')->nullable();
            $table->string('leavedate')->nullable();
            $table->string('leavetype')->nullable();
            $table->string('days')->nullable();
            $table->string('status')->nullable();
            $table->string('reason')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staffleaves');
    }
}
