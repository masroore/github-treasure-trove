<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines for all the Mails sent by the application.
    |--------------------------------------------------------------------------
    */
    'hello' => 'Hello',
    'whoops' => 'Whoops',
    'regards' => 'Regards',
    'team' => 'The :app Team',
    'automated_email' => 'This is an automated message. Do not reply to it. If you have any issues or queries get in touch with us at <a href="mailto::email">:email</a>.',
    'footer_text' => 'The contents of this e-mail and any attachments are confidential. They are intended for the named recipient(s) only. If you have received this e-mail by mistake, please notify the sender immediately and do not disclose the contents to anyone or make copies thereof.',
    'mailing_address' => 'Our mailing address:',
    'email' => 'Email:',
    'phone' => 'Phone:',
    'test' => [
        'subject' => 'This is a test email.',
        'msg_line1' => 'This is a test email sent to verify the mailer is setup and working correctly as intended.',
    ],

    'alert' => [
        'login' => [
            'new_device' => [
                'msg_line1' => 'Your <b>:app</b> was account logged in from a new device.',
                'msg_line2' => 'If this was you, you can ignore this alert. If you suspect any suspicious activity on your account, please change your password.',
            ],
        ],
        'account' => [
            'deleted' => [
                'subject' => '[ALERT] Your account has been deleted.',
                'msg_line1' => 'Your <b>:app</b> account has been deleted on <b>:time</b>',
                'msg_line2' => 'All the data associated with it along with your personally identifiable information has been deleted from our servers aswell. This is the last email notification you will receive from us unless you create a new account and opt-in again.',
                'msg_line3' => 'Its sad to see you go, if you feel there&apos;s anything we could do to better our app and services, please get in touch with us at <a href="mailto::app_email">:app_email</a>',
            ],
            'marked_deletion' => [
                'subject' => '[ALERT] Your account has been marked for deletion.',
                'msg_line1' => 'Your <b>:app</b> account has been marked for deletion and will be permanantly deleted in <b>:time</b>.',
                'msg_line2' => 'If you are not the one that marked it for deletion, log-in to your <b>:app</b> account and cancel deletion from your profile settings. Also be sure to change your master password immediately.',
                'msg_line3' => '<b>Note:</b> Once the grace period is over, all associated sites and data will be destroyed from our server. No trace of your account or profile will exist.',
                'msg_line4' => '> <b>Date of Deletion:</b> :time',
            ],
            'cancel_deletion' => [
                'subject' => '[ALERT] Your account is no longer marked for deletion.',
                'msg_line1' => 'Your <b>:app</b> account is no longer marked for deletion. The account and all associated data will remain active.',
                'msg_line2' => 'If you are not the one that cancelled the deletion, log-in to your <b>:app</b> account & change your master password immediately.',
                'msg_line3' => '> <b>Account Deletion Cancelled On:</b> :time',
            ],
            'enabled_two_step' => [
                'subject' => '[ALERT] Two-Factor Authentication (2FA) Enabled',
                'msg_line1' => 'Two-Factor Authentication (2FA) was <b>ENABLED</b> on your <b>:app</b> account on <b>:time</b>.',
                'msg_line2' => 'If you did not enable it, contact us immediately at <a href="mailto::email">:email</a>.',
                'msg_line3' => 'Enabling Two-Factor Authentication (2FA) adds an extra layer of protection to your account. If you are unable access your phone/app, you can always disable Two-Factor Authentication (2FA) using your <b>ACCESS KEY</b>.',
            ],
            'disabled_two_step' => [
                'subject' => '[WARNING] Two-Factor Authentication (2FA) Disabled',
                'subject_wp' => '[ALERT] Two-Factor Authentication (2FA) Disabled Without Phone Access',
                'msg_line1_wp' => 'Two-Factor Authentication (2FA) was just <b>disabled</b> on your <b>:app</b> account without using the Phone Authenticator App (using the <b>Access Key</b>).',
                'msg_line1' => 'Two-Factor Authentication (2FA) was <b>DISABLED</b> on your <b>:app</b> account.',
                'msg_line2' => 'If you are not the one that disabled it, log-in to your <b>:app</b> account and change your master password immediately.',
                'msg_line3' => '> <b>2-Step Disabled On</b> : <b>:time</b>',
                'msg_line4' => 'Enabling Two-Factor Authentication (2FA) adds an extra layer of security to your account. It is recommended to always keep in enabled.',
            ],
            'folder_limit' => [
                'subject' => '[ALERT] Folder Limit Reached',
                'msg_line1' => 'You have reached the maximum number of <b>Folders</b> you can add on <b>:app</b>.',
                'msg_line2' => 'If you want to create a new folder, delete any of the older folder(s) you may have. ',
            ],
            'site_limit' => [
                'subject' => '[ALERT] Site Limit Reached',
                'msg_line1' => 'You have reached the maximum number of <b>Sites</b> you can add on <b>:app</b>. ',
                'msg_line2' => 'If you want to add a new site, delete any of the older site(s) you may have. ',
            ],
            'vault_limit' => [
                'subject' => '[ALERT] Vault Limit Reached',
                'msg_line1' => 'You have reached the maximum number of <b>Vaults</b> you can create on <b>:app</b>.',
                'msg_line2' => 'If you want to create a new vault, delete any of the older vault(s) you may have. Be sure to move all the sites and data in it before deleting the vault. ',
            ],
            'vault_deleted' => [
                'subject' => '[ALERT] Your :vault Vault has been deleted.',
                'msg_line1' => 'Your Vault with the name <b>:vault</b> was deleted on <b>:time</b>*.',
                'msg_line2' => 'All the sites and data associated with it has been deleted aswell. If you did not perform this action, log-in to your <b>:app</b> account and change your master password immediately.',
            ],
            'banned' => [
                'subject' => '[ALERT] Your account has been banned.',
                'msg_line1' => 'Your <b>:app</b> account has been <b>BANNED</b> permanantly for <b>:remark</b> on <b>:time</b>.',
                'msg_line2' => 'If you feel this ban was unjust or you did not break our terms of service in any way, get in touch with us at <a href="mailto::email">:email</a> immediately.',
                'msg_line3' => '<b>Note:</b> Creating duplicate accounts for the purpose of breaking our T.O.S. will result in legal action being taken against you.',
            ],
            'unbanned' => [
                'subject' => '[ALERT] Your account ban has been revoked.',
                'msg_line1' => 'Your <b>:app</b> account ban has been <b>revoked</b> by the <b>ADMINS</b> on <b>:time</b>.',
                'msg_line2' => '<b>Note:</b> Breaking our Terms of Services, or violating our rules again will result in strict action.',
            ],
            'password_reset_success' => [
                'subject' => 'Password Reset Successful',
                'msg_line1' => 'Your <b>:app</b> account password was successfully reset on <b>:time</b>.',
                'msg_line2' => 'If you did not reset the password yourself, get in touch with us immediately at <a href="mailto::email">:email</a>.',
            ],
            'login_new_device' => [
                'msg_line1' => 'You have successfully logged into your <b>:app</b> account using <a href="mailto::email">:email</a> on <b>:time</b>.',
                'msg_line2' => 'Your IP Address is <b>:ip</b> and you are using <b>:browser</b>.',
                'msg_line3' => 'If this was you, you can ignore this alert. If you suspect any suspicious activity on your account, change your master password immediately. Also do not forget to Two-Factor Authentication (2FA).',
            ],
        ],
    ],
];
