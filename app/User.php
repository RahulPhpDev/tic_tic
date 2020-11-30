<?php

namespace App;

use App\Models\Comment;
use App\Models\Like;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;

use App\Models\Video;
use App\Models\Music;
use App\Models\Follower;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    const ROLE = [
        1 => 'ADMIN',
        2 => 'USER'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fb_id', 'profile_pic', 'version', 'first_name', 'last_name', 'bio', 'gender', 'device', 'signup_type', 'username', 'action', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role_id' => 'int'
    ];



    public function scopeUserByFbId($query, $fbId)
    {
        return $query->where('fb_id', $fbId)->first();
    }
    /**
     * mutator
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getFullNameAttribute()
    {
       return $this->first_name.' '.$this->last_name;
    }

    /**
     * Has Role Admin
     */
    public function isAdmin()
    {
        return $this->role_id === array_search('ADMIN', self::ROLE);
    }

    /**
     *
     */
    public function video()
    {
        return $this->hasMany(Video::class);
    }

    /**
     *
     *
     */
    public function music()
    {
        return $this->hasMany(Music::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function followers()
    {
        return $this->hasMany(Follower::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorites()
    {
        return $this->belongsToMany(\App\Models\Music::class, "user_favorites_music");
    }

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
//     */
//    public function likedVideos()
//    {
//        return $this->belongsToMany(Video::class, 'user_video_statuses');
//    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function follower(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'followed_by');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function follow(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_by', 'user_id');
    }

/**
 * video liked by the user
 */
    public function likedVideos() :HasMany
    {
        return $this->hasMany(Like::class)->where('likeable_type', Video::class);
    }


    public function commetableVideos() :HasMany
    {
        return $this->hasMany(Comment::class)->where('commentable_type', Video::class);
    }

/**
 * like by other on user's video
 */
    public function userVideosLike() : HasManyThrough
    {
        return $this->hasManyThrough(
            Like::class,
            Video::class,
            'user_id', // Foreign key on video table...
            'likeable_id' // video id in like table..

        )->where('likeable_type', Video::class);
    }


}
