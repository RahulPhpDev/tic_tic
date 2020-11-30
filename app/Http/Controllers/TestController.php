<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function GuzzleHttp\json_decode;
use Illuminate\Support\Facades\Validator;

use App\Service\VideoConverterService;



use App\Models\Music;
use App\Models\Video;
use App\Models\Section;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Jobs\ProceesMp3ToAac;
use App\Jobs\PorcessUploadAdminVideoJob;
use Storage;

class TestController extends Controller
{
    //
    public function test(Request $request)
    {
        // dd($request->video);
        // ============= Upload Video =====================

dd( $request->video->getClientOriginalExtension());


        $video = Video::create($request->only('music_id', 'description', 'section_id', 'user_id'));
        $video->save();
// dd($video);
        $videoName = getVideoName(
            $video,
            $request->video->getClientOriginalExtension()
        );
        $videoPath = "videos/video";
        $request->video->storeAs( $videoPath,  $videoName  );
        $video->video =  $videoPath.'/'.$videoName;
        PorcessUploadAdminVideoJob::dispatch($video);
dd('dekho');
        // ====================End UPload Video=====================
        // dd(env('QUEUE_DRIVER'));
        $music = Music::create($request->only('name', 'description', 'section_id'));
        $ex = $request->file->getClientOriginalExtension();
        // dd($ex);
        $imageName = strtolower(str_replace(' ', '_', $music->name)).'_'.$music->id.'.'.$ex;
        $request->file->storeAs("music/$ex", $imageName );
        $music->thumb = $imageName;
        $music->{$ex} = "music/$ex/".$imageName;
        $music->save();

        ProceesMp3ToAac::dispatch($music, $ex);

        // dd('yaha tak');
        return redirect()->route('admin.music.index');

        // $audioFile ='C:\xampp\htdocs\xcoders\tic_tic\API\storage\app\public\music/dekho.mp3';


        $videoConverterService = new VideoConverterService();

        $videoConverterService
        // ->convertToAac($audioFile,'checkItsomwhere');

        ->openFile('C:\xampp\htdocs\xcoders\tic_tic\API\storage\app\public\3793279379/7.mp4')
        ->createThumbnail('video', 'custom.png')
        // ->createGif('video', 'custom.gif')
        ->convertToMp3('checkItsomwhere')
        ->convertToAac('checkItsomwhereAac');
        dd('cehck');
    //     dd(base_path('\extensions\ffmpeg\ffmpeg.exe'));
    //     $ffmpeg = \FFMpeg\FFMpeg::create([
    //         'ffmpeg.binaries'  => 'C:/FFmpeg/bin/ffmpeg.exe',
    //         'ffprobe.binaries' => 'C:/FFmpeg/bin/ffprobe.exe'
    //     ]);

    //     $video = $ffmpeg ->open('C:\xampp\htdocs\xcoders\tic_tic\API\storage\app\public\3793279379/7.mp4');
    //     $frame = $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(6));
    //     $frame->save('C:\xampp\htdocs\xcoders\tic_tic\API\storage\app\public\image.jpg');

    //     $video
    // ->gif(FFMpeg\Coordinate\TimeCode::fromSeconds(2), new FFMpeg\Coordinate\Dimension(640, 480), 3)
    // ->save('C:\xampp\htdocs\xcoders\tic_tic\API\storage\app\public\dummy.gif');

    //     dd($frame);
    //     // $r = FFMpeg::fromDisk('songs');


    //     dd('test');
    }


    public function create(Request $request)
    {
        $content = $request->getContent(); // when we have  raw post data
        $contentArr = json_decode($content, true);
        dd($contentArr);
//        $this->validate($request,  [
//            'name' => 'required|min:21',
//        ]);
//      $validate =  Validator::make($contentArr, [
//            'name' => 'required|min:21',
//          "dd" => 'required'
//        ]);
//      if( $validate->fails() ){
//          dd('fail', $validate->messages()->first());
//      }
//        dd('past', $request);
    }

    function trimContent($content)
    {
       return array_map(function ($data) {
           return trim($data);
       } , $content);


    }
}
