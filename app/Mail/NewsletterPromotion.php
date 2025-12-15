<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterPromotion extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $title,
        public string $content,
        public string $buttonUrl,
        public string $buttonText,
        public string $unsubscribeToken,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter.promotion',
            with: [
                'title' => $this->title,
                'content' => $this->content,
                'buttonUrl' => $this->buttonUrl,
                'buttonText' => $this->buttonText,
                'unsubscribeUrl' => route('newsletter.unsubscribe', [
                    'token' => $this->unsubscribeToken,
                ]),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
