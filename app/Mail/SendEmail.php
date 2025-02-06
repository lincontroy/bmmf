<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $title;
    public string $mailSubject;
    public string $htmlData;

    /**
     * Create a new message instance.
     */
    public function __construct(string $title, string $subject, string $htmlData)
    {
        $this->title       = $title;
        $this->mailSubject = $subject;
        $this->htmlData    = $htmlData;
    }

    public function build()
    {
        return $this->view('emails.email_template')
            ->subject($this->mailSubject)
            ->with([
                'title'    => $this->title,
                'htmlData' => $this->htmlData,
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.email_template',
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
