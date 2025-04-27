<?php

namespace App\Mail;

use App\Models\Candidature;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CandidatureStatusNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $candidature;
    public $statut;

    public function __construct(Candidature $candidature, string $statut)
    {
        $this->candidature = $candidature;
        $this->statut = $statut;
    }

    public function build()
    {
        \Log::info('Construction du mailable de statut pour la candidature : ' . $this->candidature->id);
        \Log::info('Nouveau statut : ' . $this->statut);
        
        $subject = match($this->statut) {
            'acceptée' => 'Votre candidature a été acceptée',
            'refusée' => 'Votre candidature a été refusée',
            'en_attente' => 'Mise à jour du statut de votre candidature',
            default => 'Mise à jour du statut de votre candidature'
        };

        return $this->subject($subject)
                   ->view('mail.candidature-status');
    }
}