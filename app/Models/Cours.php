<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $table = 'cours';

    protected $fillable = [
        'titre',
        'description',
        'contenu',
        'resume',
        'video_url',
        'document_path',
        'image_path',
        'classe_id',
        'matiere_id',
        'user_id',
        'statut',
        'ordre',
    ];

    protected $casts = [
        'statut' => 'boolean',
    ];

    // Relations
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function chapitres()
    {
        return $this->hasMany(Chapitre::class)->orderBy('ordre');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('statut', true);
    }

    public function scopeByClasse($query, $classeId)
    {
        return $query->where('classe_id', $classeId);
    }

    // Accesseurs
    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : asset('admin/images/default-course.jpg');
    }

    public function getDocumentUrlAttribute()
    {
        return $this->document_path ? asset('storage/' . $this->document_path) : null;
    }
}