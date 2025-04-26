<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signalement extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'type', // offre, profil, commentaire
        'target_id',
        'motif',
        'description',
        'statut',
        'traitement_date',
        'traitement_description'
    ];
}
