<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Transaction extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'id',
        'source_type',
        'source_id',
        'user_id',
        'price',
        'payed_at',
        'created_at',
        'updated_at',
    ];
}
