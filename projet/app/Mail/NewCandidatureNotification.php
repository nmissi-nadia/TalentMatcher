<?php

namespace App\Mail;

use App\Models\Annonce;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCandidatureNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $offre;
    public $candidat;

    public function __construct(Annonce $offre, User $candidat)
    {
        $this->offre = $offre;
        $this->candidat = $candidat;
    }

    public function build()
    {
        \Log::info('Construction du mailable pour l\'offre : ' . $this->offre->titre);
        \Log::info('Nom du candidat : ' . $this->candidat->name);
        
        return $this->subject('Nouvelle candidature pour votre offre : ' . $this->offre->titre)
                ->view('mail.newcandidature');
    }
}