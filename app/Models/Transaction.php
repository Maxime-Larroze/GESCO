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
        'price',
        'title',
        'comment',
        'organisation_id',
        'created_at',
        'updated_at',
    ];
}
