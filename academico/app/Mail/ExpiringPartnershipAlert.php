<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExpiringPartnershipAlert extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $partner;

    /**
     * Create a new message instance.
     */
    public function __construct($partner)
    {
        $this->partner = $partner;
    }

    public function build()
    {
        return $this->subject('Expiration prochaine d\'un convenio')->view('emails.expiring_partnership_alert');
    }
}
