<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'fullname',
        'email',
        'role',
        'phone',
        'address',
        'avatar',
        'num',
        'status',
        'email_verified_at',
        'remember_token',
        'created_at',
        'updated_at',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function likedSongs()
    {
        return $this->belongsToMany(Song::class, 'song_user_likes', 'user_id', 'song_id')
            ->withTimestamps();
    }

    public function listeningHistory()
    {
        return $this->hasMany(ListeningHistory::class);
    }

    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('status', true)
            ->where('expires_at', '>', now());
    }
    // Controller

    public function dashboard()
    {
        $totalUsers = User::count();

        return view('admin.dashboard', compact('totalUsers'));
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
