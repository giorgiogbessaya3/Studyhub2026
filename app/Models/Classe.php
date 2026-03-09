<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'niveau',
        'description',
        'ordre',
        'statut',
    ];

    protected $casts = [
        'statut' => 'boolean',
        'ordre' => 'integer',
    ];

    /**
     * Relation avec les matières (many-to-many)
     */
    public function matieres()
    {
        return $this->belongsToMany(Matiere::class, 'classe_matiere')
                    ->withTimestamps();
    }

    /**
     * Relation avec les épreuves (one-to-many)
     */
    public function epreuves()
    {
        return $this->hasMany(Epreuve::class);
    }

    /**
     * Relation avec les cours (one-to-many)
     */
    public function cours()
    {
        return $this->hasMany(Cours::class);
    }

    /**
     * Relation avec les questions d'assistance (one-to-many)
     */
    public function assistanceQuestions()
    {
        return $this->hasMany(Assistance::class);
    }

    /**
     * Scope pour les classes actives
     */
    public function scopeActives($query)
    {
        return $query->where('statut', true);
    }

    /**
     * Scope pour l'ordre
     */
    public function scopeOrdonnees($query)
    {
        return $query->orderBy('ordre')->orderBy('nom');
    }
}