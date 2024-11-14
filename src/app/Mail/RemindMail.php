<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RemindMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $reservation;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reservation, $url)
    {
        $this->reservation = $reservation;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.remind')
        ->subject('ご予約が近づいてまいりました')
        ->with([
            'message_content' => $this->reservation,
            'url' => $this->url
        ]);
    }
}
