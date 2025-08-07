<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable {
    
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'image',
        'bio',
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected function casts(): array {

        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function posts() {
        return $this->hasMany(Post::class);
    }


    public function following() {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }


    public function followers() {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }


    public function imageUrl() {
        if ($this->image) {
            return Storage::url($this->image);
        }
        
        return null;
    }


    public function isFollowedBy(?User $user) {
        if (!$user) {
            return false;
        }
        
        return $this->followers()->where('follower_id', $user->id)->exists();
    }


    public function hasClapped(Post $post) {
        return $post->claps()->where('user_id', $this->id)->exists();
    }
}
