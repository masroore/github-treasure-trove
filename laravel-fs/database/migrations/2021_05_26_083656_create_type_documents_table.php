<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('type_documents', function (Blueprint $table): void {
            $table->id();
            $table->string('name_document', 50);
            $table->string('abbreviation', 10);

            $table->unsignedBigInteger('type_client_id');

            $table->foreign('type_client_id')->references('id')->on('type_clients');
        });
        DB::table('type_documents')->insert([
            [
                'name_document' => 'VENEZOLANO',
                'abbreviation' => 'V',
                'type_client_id' => '1',
            ],
            [
                'name_document' => 'EXTRANJERO',
                'abbreviation' => 'E',
                'type_client_id' => '1',
            ],
            [
                'name_document' => 'JURIDICO',
                'abbreviation' => 'J',
                'type_client_id' => '2',
            ],
            [
                'name_document' => 'GUBERNAMENTAL',
                'abbreviation' => 'G',
                'type_client_id' => '2',
            ],
            [
                'name_document' => 'PASAPORTE',
                'abbreviation' => 'P',
                'type_client_id' => '2',
            ],
            [
                'name_document' => 'CONSEJOS COMUNALES, COMUNAS',
                'abbreviation' => 'C',
                'type_client_id' => '2',
            ],
            [
                'name_document' => 'MENORES DE EDAD, COMUNAS',
                'abbreviation' => 'M',
                'type_client_id' => '2',
            ],
            [
                'name_document' => 'SUCESIONES',
                'abbreviation' => 'S',
                'type_client_id' => '2',
            ],

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_documents');
    }
}
