<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotisation extends Model
{
    use HasFactory;

    protected $fillable = ['montant', 'date', 'membre_id', 'tontine_id'];

    protected $casts = [
        'date' => 'date',
    ];

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    public function tontine()
    {
        return $this->belongsTo(Tontine::class);
    }
}
