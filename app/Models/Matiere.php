<?php
// app/Models/Matiere.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'code',
        'description',
        'image',
        'couleur',
        'icone',
        'statut',
    ];

    protected $casts = [
        'statut' => 'boolean',
    ];

    // Accesseur pour l'URL de l'image
    public function getImageUrlAttribute()
    {
        return $this->image 
            ? asset('storage/' . $this->image) 
            : asset('admin/images/default-matiere.jpg');
    }

    // Relation avec les classes (many-to-many)
    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'classe_matiere')
                    ->withTimestamps();
    }

    // Relation avec les épreuves (one-to-many)
    public function epreuves()
    {
        return $this->hasMany(Epreuve::class);
    }

    // Relation avec les chapitres (one-to-many) - AJOUT IMPORTANT
    public function chapitres()
    {
        return $this->hasMany(Chapitre::class);
    }
}