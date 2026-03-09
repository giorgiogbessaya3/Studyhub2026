<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapitre_id',
        'titre',
        'resume',
        'images',
        'exercices',
        'ordre',
    ];

    protected $casts = [
        'images' => 'array',
        'exercices' => 'array',
    ];

    public function chapitre()
    {
        return $this->belongsTo(Chapitre::class);
    }

    // URLs des images
    public function getImagesUrlsAttribute()
    {
        if (!$this->images) return [];
        
        return collect($this->images)->map(function($image) {
            return asset('storage/' . $image);
        })->toArray();
    }
}