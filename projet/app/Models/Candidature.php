<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Annonce;
use App\Models\User;
use App\Models\EtapeEntretienOral;
use App\Models\EtapeTestTechnique;
use App\Models\EtapeValidationFinale;

class Candidature extends Model
{
    use HasFactory;
    protected $fillable = [
        'annonce_id',
        'candidat_id',
        'lettre_motivation',
        'cv',
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
   
    public function testTechnique()
    {
        return $this->hasOne(EtapeTestTechnique::class, 'candidature_id');
    }

    public function entretienOral()
    {
        return $this->hasOne(EtapeEntretienOral::class, 'candidature_id');
    }

    public function validation()
    {
        return $this->hasOne(EtapeValidationFinale::class, 'candidature_id');
    }
}
