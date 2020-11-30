<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use App\Enums\FilterEnum;

class Filter extends Model
{
   public $fillable = ['name', 'description', 'thumb', 'file', 'category_id'];


   public function getThumbAttribute($url)
   {
       return Storage::url(FilterEnum::THUMB_PATH.'/'.$url);
   }
   public function getFileAttribute($url)
   {
       return Storage::url(FilterEnum::FILE_PATH.'/'.$url);
   }


    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
