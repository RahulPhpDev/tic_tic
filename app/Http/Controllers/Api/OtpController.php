<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Otp;
use Carbon\Carbon;
use App\Http\Resources\Api\OtpResource;

class OtpController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required'
        ]);
        // Otp::where('mobile')
        $data = Otp::create(
           [
               'mobile' => $request->mobile,
               'otp' => $this->generateOTP(),
               'expire_on' =>  Carbon::parse(now())->addHour(),
           ] 
        );
        return (new OtpResource($data))->response()->setStatusCode(201);
    }

    public function verify(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required',
            'otp' => 'required'
        ]);

        $result = Otp::where([
            ['mobile' , $request->mobile],
            ['otp' , $request->otp],
            ['expire_on', '>', now()]
        ])->first();
        if( collect($result)->isEmpty() ) {
            return \response(['data' => 'code is not valid'])->setStatusCode(422);
        }
        $result->delete();
        return response(['data' => 'code is  valid'])->setStatusCode(200);

    }

    protected function getResponse($result)
    {

        if ( !$result) {
            $msg = 'Found';
            $status = 200;
        }
    } 

    public function generateOTP(){
        $otp = mt_rand(1000,9999);
        return $otp;
    }

}
