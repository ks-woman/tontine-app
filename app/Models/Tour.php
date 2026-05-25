<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = ['ordre', 'membre_id', 'tontine_id'];

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    public function tontine()
    {
        return $this->belongsTo(Tontine::class);
    }
}
