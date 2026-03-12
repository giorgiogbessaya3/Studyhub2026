<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'admin', 'enseignant', 'eleve'
        'is_active',
        'avatar',
        'bio',
        'classe_id' // pour les élèves
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Relations pour l'assistance
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function reponses()
    {
        return $this->hasMany(Reponse::class);
    }

    /**
     * Relations existantes (à adapter selon votre base)
     */
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function coursSuivis()
    {
        return $this->belongsToMany(Cours::class, 'cours_user')->withTimestamps();
    }

    public function resultatsQuiz()
    {
        return $this->hasMany(ResultatQuiz::class);
    }

    /**
     * Vérification des rôles
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isEnseignant()
    {
        return $this->role === 'enseignant';
    }

    public function isEleve()
    {
        return $this->role === 'eleve';
    }

    /**
     * Accesseurs
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=3b82f6&color=fff';
    }
}