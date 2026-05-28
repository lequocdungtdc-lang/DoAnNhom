<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Song extends Model
{
    use HasFactory;

    protected $table = 'songs';

    protected $fillable = [
        'title',
        'artist_id',
        'category_id',
        'album_id',
        'audio_file',
        'thumbnail',
        'listen_count',
        'status',
        'is_vip',
    ];

    protected $casts = [
        'listen_count' => 'integer',
        'status' => 'boolean',
        'is_vip' => 'boolean',
    ];

    // Quan hệ với nghệ sĩ (Artist)
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'song_user_likes', 'song_id', 'user_id');
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_song')
            ->withTimestamps();
    }

    public function listeningHistory()
    {
        return $this->hasMany(ListeningHistory::class);
    }

    // public function songView()
    // {
    //     return $this->hasOne(SongView::class);
    // }

    public function getViewCountAttribute()
    {
        return $this->songView ? $this->songView->views : 0;
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
