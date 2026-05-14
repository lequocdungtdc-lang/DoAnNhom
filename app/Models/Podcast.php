<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{

    protected $fillable = [
    'title',
    'description',
    'audio_file',
    'thumbnail',
    'duration',
    'views',
    'status',
];
}
