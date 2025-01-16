<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Contact;

class ContactFormMail extends Mailable
{
    use SerializesModels;

    public $message;

    public function __construct(Contact $message)
    {
        $this->message = $message;
    }

    public function build()
    {
        return $this->markdown('emails.contact-form')
                    ->subject('New Contact Form Submission');
    }
}