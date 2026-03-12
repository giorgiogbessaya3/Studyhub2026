<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'classe_id',
        'matiere_id',
        'chapitre_id',
        'duree',
        'nombre_questions',
        'score_passer',
        'statut',
        'image',
        'created_by'
    ];

    protected $casts = [
        'statut' => 'string'
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function chapitre()
    {
        return $this->belongsTo(Chapitre::class);
    }

    public function createur()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('ordre');
    }

    public function resultats()
    {
        return $this->hasMany(QuizResultat::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/quiz/' . $this->image);
        }
        return asset('images/default-quiz.jpg');
    }

    public function getStatutBadgeAttribute()
    {
        return match($this->statut) {
            'brouillon' => '<span class="badge bg-secondary">Brouillon</span>',
            'publie' => '<span class="badge bg-success">Publié</span>',
            'archive' => '<span class="badge bg-warning">Archivé</span>',
            default => '<span class="badge bg-light">Inconnu</span>'
        };
    }

    public function getDureeFormateeAttribute()
    {
        if ($this->duree < 60) {
            return $this->duree . ' min';
        }
        $heures = floor($this->duree / 60);
        $minutes = $this->duree % 60;
        return $heures . 'h' . ($minutes ? str_pad($minutes, 2, '0', STR_PAD_LEFT) : '');
    }

    public function getNombreTentativesAttribute()
    {
        return $this->resultats()->count();
    }

    public function getScoreMoyenAttribute()
    {
        return round($this->resultats()->avg('score'), 1);
    }
}