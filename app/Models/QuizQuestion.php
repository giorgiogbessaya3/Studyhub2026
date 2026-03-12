<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $table = 'quiz_questions';

    protected $fillable = [
        'quiz_id',
        'titre',
        'type',
        'options',
        'bonne_reponse',
        'points',
        'explication',
        'image',
        'ordre'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/quiz-questions/' . $this->image);
        }
        return null;
    }

    public function getTypeLibelleAttribute()
    {
        return match($this->type) {
            'qcm' => 'QCM',
            'texte' => 'Question ouverte',
            'vrai_faux' => 'Vrai/Faux',
            default => $this->type
        };
    }

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'qcm' => 'ti ti-list-check',
            'texte' => 'ti ti-text',
            'vrai_faux' => 'ti ti-toggle',
            default => 'ti ti-question-mark'
        };
    }
}