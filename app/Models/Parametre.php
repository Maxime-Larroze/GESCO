<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'societe_name',
        'siret',
        'ape',
        'taux_accompte',
        'mention_a',
        'mention_b',
        'domiciliation',
        'rib',
        'iban',
        'bic',
        'adresse',
        'created_at',
        'updated_at',
    ];
}