<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;
    public string $url;
    public string $welcomeMsg;

    /**
     * Create a new message instance.
     */
    public function __construct(string $url, string $welcomeMsg)
    {
        $this->url = $url;
        $this->welcomeMsg = $welcomeMsg;
    }

    public function build()
    {
        return $this->view('emails.user_welcome')
            ->subject('Welcome to Our Website')
            ->with([
                'url' => $this->url,
                'welcomeMsg' => $this->welcomeMsg
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Welcome Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.user_welcome',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
