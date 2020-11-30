<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SectionCollection;
use App\Models\Section;
use Illuminate\Http\Request;
use DB;
class DiscoverController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');
        \DB::table('video')
            ->
       $sections =  Section::with(
            [
               'video',
               'video.user',
               'video.music',
               'video.likeable'
            ]
        )->get();
       return (new SectionCollection($sections) )->response()->setStatusCode(200);
    }
}
