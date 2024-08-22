<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $subject;
    public $email;
    /**
     * Create a new message instance.
     */
    public function __construct($data, $subject, $email)
    {
        $this->data = $data;
        $this->subject = $subject;
        $this->email = $email;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject($this->subject)->markdown('emails.SubscriptionMail', ['data' => $this->data]);
    }
}
