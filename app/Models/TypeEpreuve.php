<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TypeEpreuve extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'description',
        'icone',
        'statut',
    ];

    protected $casts = [
        'statut' => 'boolean',
    ];

    // Génération automatique du slug à partir du nom
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($type) {
            $type->slug = Str::slug($type->nom);
        });

        static::updating(function ($type) {
            $type->slug = Str::slug($type->nom);
        });
    }

    public function epreuves()
    {
        return $this->hasMany(Epreuve::class);
    }
    
}