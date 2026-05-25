<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'annonce_id',
        'membre_id',
        'message',
        'statut',
    ];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }
}
