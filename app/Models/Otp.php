<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    public $fillable = ['mobile', 'otp', 'expire_on'];

    public function generateOtp()
    {
        return \rand(0,4);
    }
}
