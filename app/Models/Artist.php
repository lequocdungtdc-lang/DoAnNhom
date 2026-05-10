<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_artist',
        'image_artist',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function songs()
    {
        return $this->hasMany(Song::class, 'nghesi');
    }
}
