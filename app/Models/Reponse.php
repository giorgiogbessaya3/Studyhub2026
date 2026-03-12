<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenu',
        'question_id',
        'user_id',
        'statut', // 'en_attente', 'approuvee', 'rejetee'
        'est_solution'
    ];

    protected $casts = [
        'est_solution' => 'boolean'
    ];

    // Relations
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accesseurs
    public function getStatutBadgeAttribute()
    {
        return match($this->statut) {
            'en_attente' => '<span class="badge bg-warning">En attente</span>',
            'approuvee' => '<span class="badge bg-success">Approuvée</span>',
            'rejetee' => '<span class="badge bg-danger">Rejetée</span>',
            default => '<span class="badge bg-light">Inconnu</span>'
        };
    }

    // Scopes
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeApprouvees($query)
    {
        return $query->where('statut', 'approuvee');
    }

    public function scopeSolutions($query)
    {
        return $query->where('est_solution', true);
    }
}