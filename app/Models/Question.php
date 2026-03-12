<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'contenu',
        'image',
        'classe_id',
        'matiere_id',
        'user_id',
        'statut', // 'en_attente', 'publiee', 'resolue', 'fermee'
        'views',
        'reponses_count',
        'derniere_reponse_at'
    ];

    protected $casts = [
        'statut' => 'string',
        'derniere_reponse_at' => 'datetime'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function reponses()
    {
        return $this->hasMany(Reponse::class)->orderBy('created_at', 'asc');
    }

    public function reponsesApprouvees()
    {
        return $this->hasMany(Reponse::class)->where('statut', 'approuvee');
    }

    // Accesseurs
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/assistance/' . $this->image);
        }
        return null;
    }

    public function getStatutBadgeAttribute()
    {
        return match($this->statut) {
            'en_attente' => '<span class="badge bg-warning">En attente</span>',
            'publiee' => '<span class="badge bg-success">Publiée</span>',
            'resolue' => '<span class="badge bg-info">Résolue</span>',
            'fermee' => '<span class="badge bg-secondary">Fermée</span>',
            default => '<span class="badge bg-light">Inconnu</span>'
        };
    }

    public function getStatutTextAttribute()
    {
        return match($this->statut) {
            'en_attente' => 'En attente de modération',
            'publiee' => 'Publiée',
            'resolue' => 'Résolue',
            'fermee' => 'Fermée',
            default => 'Inconnu'
        };
    }

    // Méthodes
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function updateReponsesCount()
    {
        $this->reponses_count = $this->reponses()->count();
        $this->derniere_reponse_at = now();
        $this->save();
    }

    // Scopes
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopePubliees($query)
    {
        return $query->where('statut', 'publiee');
    }

    public function scopeResolues($query)
    {
        return $query->where('statut', 'resolue');
    }

    public function scopeParClasse($query, $classeId)
    {
        return $query->where('classe_id', $classeId);
    }

    public function scopeParMatiere($query, $matiereId)
    {
        return $query->where('matiere_id', $matiereId);
    }
}