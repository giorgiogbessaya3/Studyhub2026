<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'cycle',        // Ajout du champ cycle
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
     * Relation avec les chapitres (one-to-many)
     */
    public function chapitres()
    {
        return $this->hasMany(Chapitre::class);
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
     * Scope pour le cycle collège
     */
    public function scopeCollege($query)
    {
        return $query->where('cycle', 'college');
    }

    /**
     * Scope pour le cycle lycée
     */
    public function scopeLycee($query)
    {
        return $query->where('cycle', 'lycee');
    }

    /**
     * Scope pour l'ordre
     */
    public function scopeOrdonnees($query)
    {
        return $query->orderBy('ordre')->orderBy('nom');
    }

    /**
     * Vérifier si la classe est au collège
     */
    public function isCollege()
    {
        return $this->cycle === 'college';
    }

    /**
     * Vérifier si la classe est au lycée
     */
    public function isLycee()
    {
        return $this->cycle === 'lycee';
    }
}