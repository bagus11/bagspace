<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignatureNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket,$head,$target,$subjectText)
    {
        $this->ticket = $ticket;
        $this->head = $head;
        $this->target = $target;
        $this->subjectText = $subjectText;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.signature_notification')
                    ->with([
                        'ticket' => $this->ticket,
                        'head' => $this->head,
                        'target' => $this->target
                    ])
                    ->subject($this->subjectText);
    }
}
