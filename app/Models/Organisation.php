<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Organisation extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'id',
        'user_id',
        'slug',
        'name',
        'email',
        'tel',
        'address',
        'type',
        'created_at',
        'updated_at',
    ];

    public function missions()
    {
        return $this->hasMany(Mission::class);
    }
}
