<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtapeValidationFinale extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_candidature',
        'statut'
    ];
    public function candidature()
    {
        return $this->belongsTo(Candidature::class);
    }
    
    public function etapesEntretienOral()
    {
        return $this->hasMany(EtapeEntretienOral::class);
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
