<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QrcodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message_content;
    public $qrcode;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message_content, $qrcode)
    {
        $this->message_content = $message_content;
        $this->qrcode = $qrcode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.qrcode')
            ->subject('ご予約の確認について')
            ->with([
                'message_content' => $this->message_content,
                'qrcode' => $this->qrcode
            ]);
    }
}
