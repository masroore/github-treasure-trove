<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyEmailTempatesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('email_templates', function (Blueprint $table): void {
            $table->string('for')->default('email');
        });

        DB::table('email_templates')->where('type', 'due_customer_sms_template')->update([
            'for' => 'sms',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
}
