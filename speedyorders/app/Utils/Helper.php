<?php

namespace App\Utils;

use App\Jobs\SendEmail;
use App\Models\EmailTemplate;

class Helper
{
    // ADMIN USERS TABLE STATUS
    public const DELETED = 0;

    public const INACTIVE = 0;

    public const ACTIVE = 1;

    public const AGENT_DISAPPROVE_STATUS = 0;

    public const AGENT_APPROVE_STATUS = 1;

    /**
     * RBAC ROLES.
     */
    public const SUPER_ADMIN_ROLE = 1;

    /**
     * minio folder path.
     */
    public const ASSETS_FOLDER = 'assets/';

    public static function sendMail($emailPayload)
    {
        try {
            $emailTemplate = isset($emailPayload['template_id']) ? EmailTemplate::find($emailPayload['template_id']) : null;
            $emailBody = ($emailTemplate) ? $emailTemplate->description : $emailPayload['body'];
            $emailSubject = ($emailTemplate) ? $emailTemplate->subject : $emailPayload['subject'];
            $email_job = [
                'subject' => $emailSubject,
                'to' => $emailPayload['email'],
                'body' => $emailBody,
                'has_attachment' => $emailPayload['file'] ?? '',
            ];

            $vars = [
                '[[FULL_NAME]]' => $emailPayload['name'],
                '[[BODY]]' => $emailBody,
            ];

            $email_job['vars'] = $vars;

            SendEmail::dispatch($email_job);

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
