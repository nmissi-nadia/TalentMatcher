<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Annonce;
use App\Models\Candidature;

class Signalement extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'cible_type', // offre, profil, commentaire
        'cible_id',
        'motif',
        'description',
        'statut',
    ];
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cible()
    {
        return $this->morphTo('cible_type', 'cible_id');
    }
    
}
