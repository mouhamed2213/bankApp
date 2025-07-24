<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class GenericNotification extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $titreEmail;
    public string $messageContenu;

    public function __construct(User $user, string $titreEmail, string $messageContenu)
    {
        $this->user = $user;
        $this->titreEmail = $titreEmail;
        $this->messageContenu = $messageContenu;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->titreEmail,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.generic-notification',
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



