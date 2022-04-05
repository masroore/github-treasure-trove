<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable();
            $table->string('name');
            // $table->boolean('by_admin')->default(false);
            $table->bigInteger('customer_id');
            $table->bigInteger('parent_id')->nullable();
            $table->text('content');
            $table->timestamps();
            $table->index(['customer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
}
