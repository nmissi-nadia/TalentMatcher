<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtapeTestTechnique extends Model
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
    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }
    public function candidat()
    {
        return $this->belongsTo(User::class);
    }
    public function recruteur()
    {
        return $this->belongsTo(User::class);
    }
    public function etapes()
    {
        return $this->hasMany(Etape::class);
    }
}
