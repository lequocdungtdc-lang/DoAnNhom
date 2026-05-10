<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Song extends Model
{
    use HasFactory;

    protected $table = 'songs';

    protected $fillable = [
        'tenbaihat',
        'nghesi',
        'theloai',
        'file_amthanh',
        'anh_daidien',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Quan hệ với nghệ sĩ (Artist)
    public function artist()
    {
        return $this->belongsTo(Artist::class, 'nghesi', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'theloai', 'id');
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'song_user_likes', 'song_id', 'user_id');
    }

    public function songView()
    {
        return $this->hasOne(SongView::class);
    }

    public function getViewCountAttribute()
    {
        return $this->songView ? $this->songView->views : 0;
    }
}
