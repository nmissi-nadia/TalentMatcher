<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtapeEntretien extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_candidature',
        'id_annonce',
        'statut'
    ];
    public function candidature()
    {
        return $this->belongsTo(Candidature::class);
    }
    
}
