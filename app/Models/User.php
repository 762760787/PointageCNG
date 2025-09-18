<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Pointage;

/**
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Pointage[] $pointages
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'prenom',
        'nom',
        'identifiant_employe',
        'email',
        'password',
        'role',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the user's full name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->prenom . ' ' . $this->nom,
        );
    }

    public function pointages(): HasMany
    {
        return $this->hasMany(Pointage::class);
    }

    public function conges(): HasMany
    {
        return $this->hasMany(Conge::class);
    }
     // --- LA SOLUTION EST ICI ---
    /**
     * Retourne les initiales de l'utilisateur.
     * Par exemple, "Jean Dupont" devient "JD".
     *
     * @return string
     */
    public function getInitials(): string
    {
        $name = $this->name;
        if (empty($name)) {
            return '?';
        }

        $words = explode(' ', $name);
        $initials = '';

        // Prend la première lettre du premier mot
        $initials .= mb_substr($words[0], 0, 1);

        // Si il y a plus d'un mot, prend la première lettre du dernier mot
        if (count($words) > 1) {
            $initials .= mb_substr(end($words), 0, 1);
        }

        return mb_strtoupper($initials);
    }
}