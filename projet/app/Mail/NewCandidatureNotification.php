<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\Annonce;
use App\Models\User;

class NewCandidatureNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $offre;
    public $candidat;

    /**
     * Create a new message instance.
     */
    public function __construct($offre, $candidat)
    {
        $this->offre = $offre;
        $this->candidat = $candidat;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject('Nouvelle candidature pour votre offre : ' . $this->offre->titre)
                   ->view('mail.newcandidature');
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
