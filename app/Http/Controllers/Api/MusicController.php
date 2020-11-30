<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\MusicResource;
use Illuminate\Http\Request;
use App\Models\Music;
use App\Models\Video;
use App\Models\Section;
use App\User;
use App\Http\Resources\Api\MusicResponse;
use App\Http\Resources\Api\SectionMusicResource;
use App\Http\Resources\Api\VideoResource;

class MusicController extends Controller
{
    /**
     * $_GET["p"]=="allSounds"
     */
    public function index($fbId = null)
    {

        $userId =$fbId ? User::userByFbId($fbId)->id : null;
        $sectionMusic = Section::with(['music','music.favorites' => function ($query) use ($userId) {
                $query->where('user_id', $userId)->first();
        }])
                        ->get();
        return (new SectionMusicResource($sectionMusic))
                ->response()
                ->setStatusCode(200);
    }

// if($_GET["p"]=="fav_sound")
// insert
    public function favorites(Request $request)
    {
        // make validation here for user_id and sound_id
        $this->validate($request,[
            'fb_id'=>'required',
            'sound_id' => 'required'
         ]);
         $soundId = $request->sound_id;
        $user = User::where('fb_id', $request->fb_id)->with(['favorites'=> function ($q) use($soundId){
           return $q->where('music_id', $soundId);
        }])->first();


        if ( $user->favorites->isNotEmpty() ) {
            $user->favorites()->detach($soundId);
            return response()->json('music removed from favorites');
        }
        $user->favorites()->attach($soundId);
        $sound = Music::find($soundId);
        $array[] = [
            "id" => $soundId,
            "audio_path" => [
                "mp3" => $sound->mp3_path,
                "acc" => $sound->aac_path,
            ],
            "sound_name" => $sound->name,
            "description" => $sound->description,
            "thum" => $sound->thum,
            "section" => $sound->section->name,
        ];
        return response()->json(['msg'=> ["response" => $array]]);

    }


    /**
     * my_FavSound
     */

     public function userFavoriteMusic($userFbId)
     {
        $user = User::with("favorites")->where('fb_id', $userFbId)->first();
        // dd($user);
        return (new MusicResponse($user))->response() ;

     }

     public function musicVideos($musicId)
     {

        $musicVideos = Video::whereMusicId($musicId)->with(
            'user:id,first_name,last_name,profile_pic,fb_id',
            'likes'
            // 'music'
            )
           ->withCount(['likeable', 'comments'])
           ->paginate();
       return (new VideoResource($musicVideos))->response();
     }

     public function search(Request $request)
     {
       $music = Music::query()
        ->with(['section'])

        ->whereLike('name' , $request->search)
        ->orWhereHas('section', function ($query) use ($request) {
            $query->where('name', 'like', "%$request->search%");
        })

        ->withCount(['favorites'])
        ->paginate();
        return  MusicResource::collection($music)
        ->response()
        ->setStatusCode(200);
     }
}
