<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListeningHistory extends Model
{
    protected $table = 'listening_history';

    protected $fillable = [
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
