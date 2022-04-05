<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMomHistory extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mom_history', function (Blueprint $table): void {
            $table->unsignedInteger('user_id');
            $table->string('father_name')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('father_email')->nullable();
            $table->string('family_from')->nullable();
            $table->string('family_address')->nullable();
            $table->boolean('married')->default(false);
            $table->boolean('marriage_paper')->default(false);
            $table->boolean('usa_family')->default(false);
            $table->boolean('usa_zip')->default(false);
            $table->boolean('first_baby')->default(false);
            $table->boolean('alone_ride')->default(false);
            $table->boolean('usa_child')->default(false);
            $table->string('familiar_name')->nullable();
            $table->string('familiar_phone')->nullable();

            $table->primary('user_id');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mom_history');
    }
}
