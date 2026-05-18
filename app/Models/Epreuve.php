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

    // Relation many-to-many avec les classes
    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'epreuve_classe')
                    ->withTimestamps();
    }

    // Relation many-to-many avec les matières
    public function matieres()
    {
        return $this->belongsToMany(Matiere::class, 'epreuve_matiere')
                    ->withTimestamps();
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