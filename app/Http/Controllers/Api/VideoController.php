<?php

namespace App\Http\Controllers\Api;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserLikedResource;
use App\Models\UserVideoStatus;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Music;
use App\Http\Resources\Api\VideoResource;
use App\Http\Resources\Api\UserVideosResource;
use App\Http\Requests\Api\VideoCommentRequest;

use App\Http\Resources\Api\VideoCommentResource;
use App\Http\Resources\Api\CreateVideoCommentResource;
use App\Service\VideoConverterService;
use App\User;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ProceesMp3ToAac;

use Illuminate\Support\Facades\File;

class VideoController extends Controller
{
    public function index()
    {
       $videos = Video::with(
            'user:id,first_name,last_name,profile_pic,fb_id',
            'likes'
            )
           ->withCount(['likeable', 'comments'])
           ->paginate();
        return (  new VideoResource( $videos) )
                    ->response()
                    ->setStatusCode(200);

    }

    public function details($videoId)
    {
       $data = Video::with(
            'user:id,first_name,last_name,profile_pic,fb_id',
            'likes'
            )
           ->withCount(['likeable', 'comments'])
           ->with('music')
           ->firstOrFail($videoId);
        return response()
        ->json([
            "id" => $data->id,
            "fb_id" => $data->user->fb_id,
            'user_info' => $data->user,
            'count' => [
                "like_count" => $data->likeable_count,
                "video_comment_count" => $data->comments_count,
            ],
            "liked" =>  $data->likeable_count,
            "video" => $data->video,
            "thum"=> $data->thum,
            "gif"=> $data->gif,
            "description"=> $data->description,
            "sound" =>  array_merge(
                $data->music ? $data->music->toArray() : []
                ,
                [
                    "audio_path" => [
                        "mp3" => $data->music ? $data->music->mp3_type : null,
                        "acc" => $data->music ? $data->music->aac_path : null
                    ],
                ]
                ),
            "created_at" => $data->created_at,
        ])
                    ->setStatusCode(200);
    }

    /**
     * Request $request
     */
    public function  create(Request $request)
    {


      $data  =   $this->validate($request, [
            'fb_id' => 'required|exists:users',
            'description' => 'required',
            'video'  => 'required|mimes:mp4,oog',
            // 'section_id'
        ]);
         // we can get the music path
         if($request->audio_file)
         {
                $array =  [
                    'name' =>'Video Music',
                    'description' => 'Video Music',
                    'section_id' => $request->section_id,
                ];
                $music = Music::create( $array );
                $ex = $request->audio_file->getClientOriginalExtension();
                $imageName = strtolower(str_replace(' ', '_', $music->name)).'_'.$music->id.'.'.$ex;
                $request->audio_file->storeAs("music/$ex/", $imageName );
                $music->thumb = $imageName;
                $music->{$ex} = "music/$ex/".$imageName;
                ProceesMp3ToAac::dispatch($music, $ex);
                $music->save();
                $data['music_id'] = $music->id;
            } elseif($request->music_id) {
                $data['music_id'] = $request->music_id;
            }
        $user =   User::userByFbId($data['fb_id']);
        $request->request->remove('fb_id');

        $data['user_id'] = $user->id;
        $video = Video::create( $data);
        // =================== PIC=======================

    $directory =  "videos/$user->id/video/";
    $thumbDirectory =  "videos/$user->id/thumb/";
    $gifDirectory =  "videos/$user->id/gif/";

    Storage::makeDirectory($directory, 0775, true);
    Storage::makeDirectory($thumbDirectory, 0775, true);
    Storage::makeDirectory($gifDirectory, 0775, true);

    $fileName= getVideoName($video);
    $videoName =   $fileName.".".$request->video->getClientOriginalExtension();
    $request->video->storeAs($directory, $videoName);
    $videoConverterService = new VideoConverterService();
      $videoConverterService
        ->openFile($request->video)
        ->createThumbnail( $thumbDirectory, $fileName.'.png')
        ->createGif($gifDirectory, $fileName.'.gif');
        $video->update([
            'gif' => $gifDirectory.'/'.$fileName.'.gif',
            'thum' => $thumbDirectory.'/'.$fileName.'.png',
            'video' =>$directory . '/'.$videoName,
        ]);
        // ================= END====================

        return response(['msg' => $video])->setStatusCode(200);

    }

    public function userVideos($fbId)
    {

        $userVideos = User
        ::with(
            'video',
            'video.music',
            'video.comments',
            'video.likeable',
            'followers'
        )
        ->where('fb_id', $fbId)->get();
        return (  new UserVideosResource( $userVideos) )
                    ->response()
                    ->setStatusCode(200);
    }


    /**
     * $_GET["p"]=="likeDislikeVideo"
     */
    public function likeDislikeVideo(Request $request)
    {
        $status = $request->action;
        $fbId = $request->fb_id;
        $videoId = $request->video_id;
        $userId = User::userByFbId($fbId)->id;
        $video = Video::with('user', 'likeable')->find($videoId);
        if ( $video->likeable->isNotEmpty()) {
            $video->likeable()->delete();
            $msg = "video unlike";

        } else  {
            $video->likeable()
                    ->create([ 'user_id' => $userId ]);
            $msg = "actions success";
        }
        return response(["msg" => $msg ?? '']);
    }

    /**
     * $_GET["p"]=="postComment"
     * Post comment
     */
    public function comment(VideoCommentRequest $request)
    {
        $this->validate($request,[
            'body'=>'required',
            'user_id'=>'required',
            'video_id' => 'required'
         ]);
// https://blog.logrocket.com/polymorphic-relationships-in-laravel/
    $video = Video::findOrFail($request->video_id);
    $input = $request->only('body', 'user_id');
    $comment = $video->comments()->create( $input);
    return ( new CreateVideoCommentResource( $comment))
            ->response()
            ->setStatusCode(200);

    }

    /**
     * $_GET["p"]=="showVideoComments"
     * // showVideoComments
     */

    public function videoComment($videoId)
    {
        $video = Video::with('comments', 'comments.user:id,first_name,last_name,profile_pic,fb_id')->findOrFail($videoId);
        // dd($video->toArray());
        return new VideoCommentResource($video);
    }

    /**
     * $_GET["p"]=="my_liked_video"
     * @param $userId
     */
    public function userLikedVideos($userId)
    {
        $user =  User::with('likedVideos', 'commetableVideos')
            ->where('fb_id', $userId)->first();
        return ( new UserLikedResource($user))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * SearchByHashTag
     */
    public function search(Request $request)
    {
      $videos =   Video::query()
                    ->inRandomOrder()
                    ->whereLike('description', $request->tag)
                    ->get() ;
      $videos ->load(['user', 'music', 'likes']);
        return (  new VideoResource( $videos) )
            ->response()
            ->setStatusCode(200);
    }

    /**
     * $_GET["p"]=="updateVideoView"
     * post
     */
    public function view(Request $request)
    {
        Video::find($request->id)->increment('view');
        return response(['msg' =>
            [
                array(
                    "response" =>"success"
                )
            ]
        ]);

    }





}
