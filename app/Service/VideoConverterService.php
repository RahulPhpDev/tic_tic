<?php
namespace App\Service;
use FFMpeg;
class VideoConverterService {

    protected $ffmpeg;

    protected $file;

    protected $storagePublicPath;

    protected $music;

    public function __construct ()
    {

        $this->ffmpeg = \FFMpeg\FFMpeg::create([
            'ffmpeg.binaries'  => base_path('extensions\ffmpeg\ffmpeg.exe'),
            'ffprobe.binaries' => base_path('extensions\ffmpeg\ffprobe.exe')
        ]);

        $this->storagePublicPath = storage_path().'/app/public/';
    }

    public function openFile($filePath)
    {
       $this->file =  $this->ffmpeg->open($filePath);
        return $this;
    }

    public function createThumbnail($path, $fileName, $second = 3)
    {
       
        $frame = $this->file->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds($second));
        $finalPath = $this->storagePublicPath.$path.'/'.$fileName;
        $frame->save($finalPath);
        return $this;
    }


    public function createGif($path, $fileName, $startSecond = 1, $endSecond = 3)
    {
        $finalPath = $this->storagePublicPath.$path.'/'.$fileName;
        $this->file
            ->gif(
                 FFMpeg\Coordinate\TimeCode::fromSeconds($startSecond),
                 new FFMpeg\Coordinate\Dimension(640, 480), $endSecond
                )
            ->save($finalPath);
    }


    public function createImage()
    {

    }

    public function compressVideo()
    {

    }

    public function convertToMp3($fileName = "audio")
    {
        // Set an audio format
        $audio_format = new FFMpeg\Format\Audio\Mp3();
        $finalPath = $this->storagePublicPath.'music/mp3/'.$fileName.'.mp3';
        // Extract the audio into a new file as mp3
        $this->file->save($audio_format, $finalPath);
        return $this;
        
    }

    public function convertToAac($fileName = "audio")
    {
        $audio_format = new FFMpeg\Format\Audio\Aac();
        $finalPath = $this->storagePublicPath.'music/aac/'.$fileName.'.aac';
        $this->file->save($audio_format, $finalPath);
        return $this;
    }

}