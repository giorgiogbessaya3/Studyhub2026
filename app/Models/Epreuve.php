<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Epreuve extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'slug',
        'description',
        'classe_id',
        'matiere_id',
        'type_epreuve_id',
        'fichier',
        'nom_fichier_original',
        'annee',
        'duree',
        'bareme',
        'statut',
    ];

    protected $casts = [
        'statut' => 'boolean',
        'annee' => 'integer',
        'duree' => 'integer',
        'bareme' => 'integer',
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function typeEpreuve()
    {
        return $this->belongsTo(TypeEpreuve::class);
    }

    public function correction()
    {
        return $this->hasOne(Correction::class);
    }
}