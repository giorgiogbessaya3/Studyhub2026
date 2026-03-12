<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResultat extends Model
{
    use HasFactory;

    protected $table = 'quiz_resultats';

    protected $fillable = [
        'quiz_id',
        'user_id',
        'score',
        'reponses',
        'temps_ecoule',
        'termine_le'
    ];

    protected $casts = [
        'reponses' => 'array',
        'termine_le' => 'datetime'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPourcentageAttribute()
    {
        $totalQuestions = $this->quiz->questions()->count();
        if ($totalQuestions == 0) return 0;
        return round(($this->score / $totalQuestions) * 100, 1);
    }

    public function getEstReussiteAttribute()
    {
        return $this->pourcentage >= $this->quiz->score_passer;
    }

    public function getTempsFormateAttribute()
    {
        $minutes = floor($this->temps_ecoule / 60);
        $secondes = $this->temps_ecoule % 60;
        return $minutes . ':' . str_pad($secondes, 2, '0', STR_PAD_LEFT);
    }
}