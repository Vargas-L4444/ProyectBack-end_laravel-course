<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements MustVerifyEmail, HasMedia {
    
    use HasFactory, Notifiable, InteractsWithMedia;

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


    public function registerMediaConversions(?Media $media = null): void {
        $this
            ->addMediaConversion('avatar')
            ->width(128)
            ->crop(128, 128);
    }


    public function registerMediaCollections(): void {
        $this
            ->addMediaCollection('avatar')
            ->singleFile();

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
        $media = $this->getFirstMedia('avatar');
        if (!$media) {
            return null;
        }

        if ($media->hasGeneratedConversion('avatar')) {
            return $media->getUrl('avatar');
        }
        
        return $media->getUrl();
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
