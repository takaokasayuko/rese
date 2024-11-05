<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message_content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $message_content)
    {
        $this->subject = $subject;
        $this->message_content = $message_content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.send-email')
        ->subject($this->subject)
        ->with(['message_content' => $this->message_content]);
    }
}
