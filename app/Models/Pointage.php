<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pointage extends Model
{
    use HasFactory;

     /**
     * Le nom de la table associée au modèle.
     * C'est la ligne qui corrige le problème.
     *
     * @var string
     */
    protected $table = 'pointages';
    
    protected $fillable = ['user_id', 'date', 'heure_arrivee', 'heure_depart', 'pauses'];
    protected $casts = ['date' => 'date', 'heure_arrivee' => 'datetime', 'heure_depart' => 'datetime', 'pauses' => 'array'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
