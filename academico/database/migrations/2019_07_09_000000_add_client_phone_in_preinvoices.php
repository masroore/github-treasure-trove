<?php

use Illuminate\Database\Migrations\Migration;

class AddClientPhoneInPreinvoices extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pre_invoices', function ($table): void {
            $table->string('client_phone')->after('client_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
}
