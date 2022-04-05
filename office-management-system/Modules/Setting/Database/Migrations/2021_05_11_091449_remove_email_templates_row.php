<?php

use Illuminate\Database\Migrations\Migration;

class RemoveEmailTemplatesRow extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::table('email_templates')->whereIn('type', ['transaction_mail_template', 'login_from_new_device', 'sign_up_team_invitation', 'sign_up_project_invitation', 'task_assign', 'task_complete', 'due_date_remider', 'sign_up_email'])->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
}
