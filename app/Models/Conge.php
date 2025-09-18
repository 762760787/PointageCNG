<?php
// app/Models/Conge.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conge extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'date_debut', 'date_fin', 'type', 'motif', 'statut'];
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
