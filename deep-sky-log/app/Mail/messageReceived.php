<?php
/**
 * Message Received mailable.
 *
 * PHP Version 7
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Message Received mailable.
 *
 * @author   Wim De Meester <deepskywim@gmail.com>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 *
 * @see     http://www.deepskylog.org
 */
class messageReceived extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $subject;

    public $message;

    public $author;

    public $id;

    public $participants;

    /**
     * Create a new message instance.
     *
     * @param string  $subject      the subject of the message
     * @param string  $message      the content of the message
     * @param string  $author       the author of the message
     * @param int $id           the id of the thread
     * @param string  $participants the participants of the thread
     */
    public function __construct($subject, $message, $author, $id, $participants)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->author = $author;
        $this->id = $id;
        $this->participants = $participants;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('message-received')->with(
            [
                'subject' => $this->subject,
                'message' => $this->message,
                'author' => $this->author,
                'id' => $this->id,
                'participants' => $this->participants,
            ]
        );
    }
}
