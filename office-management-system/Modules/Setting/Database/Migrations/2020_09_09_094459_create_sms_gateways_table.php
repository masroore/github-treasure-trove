<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsGatewaysTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sms_gateways', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 200);
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
        DB::table('sms_gateways')->insert([
            [
                'name' => 'Twillo',
                'status' => '0',
                'created_at' => date('Y-m-d h:i:s'),
            ],
            [
                'name' => 'Text to Local',
                'status' => '0',
                'created_at' => date('Y-m-d h:i:s'),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_gateways');
    }
}
