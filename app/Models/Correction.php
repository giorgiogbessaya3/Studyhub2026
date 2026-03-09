<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correction extends Model
{
    use HasFactory;

    protected $fillable = [
        'epreuve_id',
        'fichier',
        'nom_fichier_original',
        'description',
    ];

    public function epreuve()
    {
        return $this->belongsTo(Epreuve::class);
    }
}