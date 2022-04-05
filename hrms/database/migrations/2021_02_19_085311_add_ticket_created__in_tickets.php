<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTicketCreatedInTickets extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(
            'tickets',
            function (Blueprint $table): void {
                $table->integer('ticket_created')->default(0)->after('ticket_code');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'tickets',
            function (Blueprint $table): void {
                $table->dropColumn('ticket_created');
            }
        );
    }
}
