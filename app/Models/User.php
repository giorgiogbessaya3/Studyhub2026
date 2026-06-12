<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'avatar',
        'bio',
        'classe_id'
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
     * Accesseur pour l'URL de l'avatar
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar && file_exists(storage_path('app/public/' . $this->avatar))) {
            return asset('storage/' . $this->avatar);
        }
        
        // Avatar par défaut avec les initiales
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=3b82f6&color=fff&size=128';
    }

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
     * Relations existantes
     */
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function resultatsQuiz()
    {
        return $this->hasMany(QuizResultat::class);
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
}