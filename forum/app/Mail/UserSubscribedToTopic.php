<?php

namespace App\Mail;

use App\Topic;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserSubscribedToTopic extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $topic;

    /**
     * Create a new message instance.
     */
    public function __construct(Topic $topic)
    {
        $this->topic = $topic;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.subscribed', [
            'topic' => $this->topic,
        ]);
    }
}
