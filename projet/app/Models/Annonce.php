<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'location',
        'competences',
        'salaire',
        'categorie_id',
        'recruteur_id',
        'statut'
    ];
    protected $casts = [
        'salaire' => 'decimal:2'
    ];
    
    public function recruteur()
    {
        return $this->belongsTo(User::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
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
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
}
