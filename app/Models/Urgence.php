<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Urgence extends Model
{
    use HasFactory;

    protected $fillable = [
        'tontine_id',
        'membre_id',
        'statut',
        'motif'
    ];

    public function tontine()
    {
        return $this->belongsTo(Tontine::class);
    }

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }
}
