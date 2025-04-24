<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Candidature;

class EtapeTestTechnique extends Model
{
    use HasFactory;
    protected $fillable = [
        'candidature_id',
        'lien_entretien',
        'commentaire',
        'statut'
    ];
    public function candidature()
    {
        return $this->belongsTo(Candidature::class);
    }
    
}
