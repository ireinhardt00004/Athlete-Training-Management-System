<?php

// app/Mail/ConcernReply.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConcernReply extends Mailable
{
    use Queueable, SerializesModels;

    public $adminEmail;
    public $replyMessage;

    public function __construct($adminEmail, $replyMessage)
    {
        $this->adminEmail = $adminEmail;
        $this->replyMessage = $replyMessage;
    }

    public function build()
    {
        return $this->subject('Concern Reply')
            ->view('email.concern-reply', [
                'adminEmail' => $this->adminEmail,
                'replyMessage' => $this->replyMessage,
            ]);
        }
}
