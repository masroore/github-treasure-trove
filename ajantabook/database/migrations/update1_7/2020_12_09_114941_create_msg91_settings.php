<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsg91Settings extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('msg91_settings')) {
            Schema::create('msg91_settings', function (Blueprint $table): void {
                $table->id();
                $table->string('key');
                $table->string('message')->nullable();
                $table->string('otp_length')->nullable();
                $table->string('otp_expiry')->nullable();
                $table->string('sender_id');
                $table->string('unicode')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('msg91_settings');
    }
}
