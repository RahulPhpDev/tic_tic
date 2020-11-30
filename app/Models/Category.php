<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public $fillable = ['title'];

    public $timestamp = 'created_at';

    const UPDATED_AT = null;

    public function filter() : HasMany
    {
        return $this->hasMany(Filter::class);
    }
}
