<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListeningHistory extends Model
{
    protected $table = 'listening_history';

    protected $fillable = [
        'user_id',
        'song_id',
        'listened_at',
        'listened_seconds',
        'has_counted',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'has_counted' => 'boolean',
        'listened_at' => 'datetime',
        'listened_seconds' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class);
    }
}
