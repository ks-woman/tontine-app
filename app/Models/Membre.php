<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Candidature;

class Membre extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'adresse',
        'email',
        'telephone',
        'date_naissance',
        'date_adhesion',
        'user_id',
        'lieu_naissance',
        'numero_piece_identite'
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'date_adhesion' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tontinesOrganisees()
    {
        return $this->hasMany(Tontine::class, 'organisateur_id');
    }

    public function tontinesCoOrganisees()
    {
        return $this->belongsToMany(Tontine::class, 'tontine_organisateurs');
    }

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function cotisations()
    {
        return $this->hasMany(Cotisation::class);
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }

    public function tontinesParticipant()
    {
        return $this->belongsToMany(Tontine::class, 'tontine_participants', 'membre_id', 'tontine_id')
            ->withPivot('role')
            ->withTimestamps();
    }
}
