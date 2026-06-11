<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'cycle',
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
     * Relation avec les épreuves (many-to-many)
     * C'est ICI qu'il faut la définir !
     */
    public function epreuves()
    {
        return $this->belongsToMany(Epreuve::class, 'epreuve_classe')
                    ->withTimestamps();
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
        return $this->hasMany(Question::class);
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
}