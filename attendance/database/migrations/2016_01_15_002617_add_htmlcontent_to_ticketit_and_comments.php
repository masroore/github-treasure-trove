<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddHtmlcontentToTicketitAndComments extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ticketit', function (Blueprint $table): void {
            $table->longText('html')->nullable()->after('content');
        });

        Schema::table('ticketit_comments', function (Blueprint $table): void {
            $table->longText('html')->nullable()->after('content');
            $table->longText('content')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticketit', function (Blueprint $table): void {
            $table->dropColumn('html');
        });

        Schema::table('ticketit_comments', function (Blueprint $table): void {
            $table->dropColumn('html');
            $table->text('content')->change();
        });
    }
}
