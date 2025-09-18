<?php
// app/Models/JourFerie.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JourFerie extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     * C'est la ligne qui corrige le problème.
     *
     * @var string
     */
    protected $table = 'jours_feries';

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = ['date', 'nom'];
}