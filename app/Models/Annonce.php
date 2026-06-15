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
        'duree_mois',
        'nombre_personnes',
        'montant_cotisation',
        'cree_par',
        'date_limite',
        'statut'
    ];

    protected $casts = [
        'date_limite' => 'date',
        'montant_cotisation' => 'decimal:2'
    ];

    public function createur()
    {
        return $this->belongsTo(User::class, 'cree_par');
    }

    public function tontine()
    {
        return $this->belongsTo(Tontine::class);
    }
}
