<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class CreateConfigTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('config', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('value')->nullable();
            $table->timestamps();
        });
        //default enrollment period set as first period
        DB::table('config')->insert([
            ['name' => 'default_enrollment_period', 'value' => 1],
            ['name' => 'current_period', 'value' => null],
            ['name' => 'institution_rules_url', 'value' => null],
            ['name' => 'moodle_url', 'value' => null],
            ['name' => 'moodle_token', 'value' => null],
            ['name' => 'first_period', 'value' => 1],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config');
    }
}
