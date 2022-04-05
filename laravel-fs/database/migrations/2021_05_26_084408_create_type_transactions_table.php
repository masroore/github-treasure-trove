<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('type_transactions', function (Blueprint $table): void {
            $table->id();
            $table->string('name_transaction', 200);
            $table->boolean('status')->default(true);
            $table->boolean('obligatory')->default(false);

            $table->unsignedBigInteger('user_id');
            $table->timestamp('date_register')->nullable();
            $table->string('ip', 20);

            $table->foreign('user_id')->references('id')->on('users');
        });
        DB::table('type_transactions')->insert([
            [
                'name_transaction' => 'Compra BS',
                'status' => 1,
                'obligatory' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_transaction' => 'Compra USD',
                'status' => 1,
                'obligatory' => 0,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_transaction' => 'Recarga Digitel',
                'status' => 1,
                'obligatory' => 0,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_transaction' => 'Recarga Movistar',
                'status' => 1,
                'obligatory' => 0,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_transaction' => 'Recarga Movilnet',
                'status' => 1,
                'obligatory' => 0,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_transaction' => 'Recarga Simple TV',
                'status' => 1,
                'obligatory' => 0,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_transactions');
    }
}
