<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class Music extends Model
{
    public $guarded = [];

    protected  $appends = ['mp3_path', 'aac_path'];

    public function getMp3PathAttribute()
    {
        return Storage::url($this->mp3);
    }



    public function getAacPathAttribute()
    {
        return Storage::url($this->aac);
    }


    public function section()
    {
        return $this->belongsTo(\App\Models\Section::class);
    }


    public function likeable()
    {
        return $this->morphMany(Like::class , 'likeable');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorites()
    {
        return $this->belongsToMany(\App\User::class, "user_favorites_music");
    }
}
