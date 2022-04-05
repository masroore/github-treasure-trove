<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $data = [];

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // common variables to all email templates
            $commonVars = [
                '[[SYSTEM_NAME]]' => '',
                '[[SYSTEM_ADDRESS]]' => '',
                '[[SYSTEM_EMAIL]]' => '',
                '[[SYSTEM_CONTACT]]' => '',
                '[[SYSTEM_LINK]]' => url('/'),
                '[[DATE]]' => date('Y'),
                //'[[SYSTEM_FACEBOOK]]' => \Options::get('facebook_url'),
                //'[[SYSTEM_INSTAGRAM]]' => \Options::get('instagram_url'),
                //'[[SYSTEM_TWITTER]]' => \Options::get('twitter_url'),
                //'[[SYSTEM_YOUTUBE]]' => \Options::get('youtube_url'),
                //'[[PRIVACY_POLICY_LINK]]' => url('/'),
                //'[[UNSUBSCRIBE_LINK]]' => url('/'),
                //'[[SUPPORT_LINK]]' => url('/'),
            ];
            $emailData = $this->data;

            $emailData['vars'] ??= [];

            //replacing the placeholders
            $varToReplace = array_merge($commonVars, $emailData['vars']);

            $emailData['body'] = strtr($emailData['body'], $varToReplace);
            Log::info('Email data' . json_encode($emailData));
            Log::info('Vars data' . json_encode($varToReplace));
            Mail::send('emails.template', $emailData, function ($message) use ($emailData): void {
                $message->to($emailData['to']);
                $message->subject($emailData['subject']);

                // If there is cc
                if (isset($emailData['cc'])) {
                    $message->cc($emailData['cc']);
                }

                // If there is an attache mtn
                if (isset($emailData['attachment'])) {
                    $message->attach($emailData['attachment']);
                }
            });
        } catch (Exception $e) {
            Log::stack(['daily'])->warning($e->getCode(), [$e->getMessage(), $e->getFile(), $e->getLine()]);
        }
    }
}
