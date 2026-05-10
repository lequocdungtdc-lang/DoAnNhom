<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongView extends Model
{
    protected $fillable = [
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
