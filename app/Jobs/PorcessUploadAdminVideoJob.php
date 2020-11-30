<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Video;
use App\Service\VideoConverterService;
use Storage;
class PorcessUploadAdminVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // video init
    public $video;

    //videoConversion
    public $videoConversion;

    // get the file path
    protected $filePath;

    // get video name
    protected $videoName;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
       $this->video = $video;
       $this->filePath =  Storage::disk('public')->path($this->video->getAttributes()['video']);
       $this->videoName = getVideoName($this->video);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // php artisan queue:retry all
        $this->videoConversion =  new VideoConverterService();
        $this->videoConversion
            ->openFile( $this->filePath);

        $this->createThumbnail();
        $this->createGif();
        //     ->createGif('videos/gif', getVideoName($this->video,'.gif') );
        $this->video->save();
    }

    public function createThumbnail()
    {
        $thumbNail = $this->videoName. '.png';
        $this->videoConversion
        ->createThumbnail('videos/thumb', $thumbNail );
        $this->video->thum = 'videos/thumb/'. $thumbNail;
    }


    public function createGif()
    {
        $gif = $this->videoName. '.gif';
        $this->videoConversion
        ->createGif('videos/gif', $gif );
        $this->video->gif =  'videos/gif/'.$gif;

    }
}
