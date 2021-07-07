<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organisation;
use App\Traits\Uuids;

class Contribution extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'id',
        'user_id',
        'price',
        'title',
        'comment',
        'organisation_id',
        'created_at',
        'updated_at',
    ];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }
}
