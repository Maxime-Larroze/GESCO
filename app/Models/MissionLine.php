<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class MissionLine extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'id',
        'user_id',
        'mission_id',
        'title',
        'quantity',
        'price',
        'unity',
        'created_at',
        'updated_at',
    ];
    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }
}
