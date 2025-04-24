<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Candidature;

class EtapeValidationFinale extends Model
{
    use HasFactory;
    protected $fillable = [
        'candidature_id',
        'commentaire',
        'statut'
    ];
    public function candidature()
    {
        return $this->belongsTo(Candidature::class);
    }
    
  
}
