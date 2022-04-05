<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeClientsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('type_clients', function (Blueprint $table): void {
            $table->id();
            $table->string('name_types', 50);
        });
        DB::table('type_clients')->insert([
            [
                'name_types' => 'NATURAL',
            ],
            [
                'name_types' => 'JURIDICO',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_clients');
    }
}
