<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('type_operators', function (Blueprint $table): void {
            $table->id();
            $table->string('description', 200);
        });
        DB::table('type_operators')->insert([
            [
                'description' => 'CASA/OFICINA',
            ],
            [
                'description' => 'CELULAR',
            ],

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_operators');
    }
}
