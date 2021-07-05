<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Mission extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'id',
        'reference',
        'organisation_id',
        'title',
        'comment',
        'deposit',
        'endred_at',
        'created_at',
        'updated_at',
    ];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function missionLines()
    {
        return $this->hasMany(MissionLine::class);
    }
}