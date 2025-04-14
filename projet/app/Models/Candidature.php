<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_annonce',
        'id_candidat',
        'statut'
    ];
    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }
    public function candidat()
    {
        return $this->belongsTo(User::class);
    }
    public function etapes()
    {
        return $this->hasMany(Etape::class);
    }
    public function etapesEntretien()
    {
        return $this->hasMany(EtapeEntretien::class);
    }
    public function etapesTestTechnique()
    {
        return $this->hasMany(EtapeTestTechnique::class);
    }
    public function etapesValidationFinale()
    {
        return $this->hasMany(EtapeValidationFinale::class);
    }
}
