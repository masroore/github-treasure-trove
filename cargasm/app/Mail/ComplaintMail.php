<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplaintMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public $template;

    public $attrs;

    /**
     * Create a new message instance.
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
