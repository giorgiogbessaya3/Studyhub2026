<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Chapitre extends Model
{
    use HasFactory;

    protected $fillable = [
        'classe_id',
        'matiere_id',
        'titre',
        'slug',
        'description',
        'ordre',
        'statut',
    ];

    protected $casts = [
        'statut' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($chapitre) {
            $chapitre->slug = Str::slug($chapitre->titre);
        });

        static::updating(function ($chapitre) {
            if ($chapitre->isDirty('titre')) {
                $chapitre->slug = Str::slug($chapitre->titre);
            }
        });
    }

    // Relations
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function contenus()
    {
        return $this->hasMany(Contenu::class)->orderBy('ordre');
    }
}