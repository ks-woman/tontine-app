<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tontine extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'duree_mois',
        'date_debut',
        'date_fin',
        'montant_cotisation',
        'frequence',
        'montant_total',
        'nbr_personne',
        'taux',
        'montant_taux',
        'organisateur_id'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function organisateur()
    {
        return $this->belongsTo(Membre::class, 'organisateur_id');
    }

    public function coOrganisateurs()
    {
        return $this->belongsToMany(Membre::class, 'tontine_organisateurs');
    }

    public function tours()
    {
        return $this->hasMany(Tour::class)->orderBy('ordre');
    }

    public function cotisations()
    {
        return $this->hasMany(Cotisation::class);
    }

    public function estGerablePar(Membre $membre)
    {
        return $this->organisateur_id === $membre->id || $this->coOrganisateurs->contains($membre->id);
    }

    public function participants()
    {
        return $this->hasMany('App\Models\TontineParticipant');
    }

    public function membresParticipants()
    {
        return $this->belongsToMany(Membre::class, 'tontine_participants', 'tontine_id', 'membre_id')
            ->withPivot('role')
            ->withTimestamps();
    }
}
