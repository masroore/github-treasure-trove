<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banks', function (Blueprint $table): void {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('document', 20);
            $table->string('name_bank', 200);
            $table->string('name_fantasy', 200);
            $table->string('phone', 200);
            $table->string('email', 50);
            $table->boolean('status')->default(false);

            $table->unsignedBigInteger('type_document_id');
            $table->unsignedBigInteger('telephone_operator_id');
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('responsible_id');

            $table->foreign('type_document_id')->references('id')->on('type_documents');
            $table->foreign('telephone_operator_id')->references('id')->on('telephone_operators');
        });
        DB::table('banks')->insert([
            [
                'code' => '0172',
                'document' => '316287599',
                'name_bank' => 'BANCAMIGA BANCO MICROFINANCIERO C.A',
                'name_fantasy' => 'BANCAMIGA',
                'phone' => '4444444',
                'email' => 'info@bancamiga.com',
                'status' => 1,
                'type_document_id' => 3,
                'telephone_operator_id' => 2,
                'address_id' => 1,
                'responsible_id' => 1,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
}
