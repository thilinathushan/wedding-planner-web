<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class PartnerInvitationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $token,
        public string $inviterName
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You\'re Invited to Plan Your Wedding!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // We generate the secure URL here and pass it to the view.
        $invitationUrl = URL::temporarySignedRoute(
            'invitations.accept',
            now()->addDays(3),
            ['token' => $this->token]
        );

        return new Content(
            markdown: 'emails.invitations.partner-invite',
            with: [
                'invitationUrl' => $invitationUrl,
            ],
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
