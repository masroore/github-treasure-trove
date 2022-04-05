<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $subject;

    protected $template;

    public $attrs = [];

    /**
     * DefaultMail constructor.
     *
     * @param $subject
     * @param $promotion
     * @param $body
     * @param $buttons
     */
    public function __construct(string $subject, string $template, array $attrs = [])
    {
        $this->subject = $subject;
        $this->template = $template;
        $this->attrs = $attrs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->view($this->template)->with($this->attrs);
    }
}
