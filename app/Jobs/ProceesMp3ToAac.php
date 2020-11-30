<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Service\VideoConverterService;
use App\Models\Music;
use Storage;

class ProceesMp3ToAac implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    protected $music;

    // this keep the extension which we are having
    protected $extension;

    //init videoConversion
    protected $videoConversion;

    // get the file path
    protected $filePath;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Music $music, $extension)
    {
        $this->music = $music;
        $this->extension = $extension;


        // Storage::disk('public')->path($music->{$extension});


        $this->filePath =  Storage::disk('public')->path($music->{$extension});

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->videoConversion =  new VideoConverterService();
        $this->videoConversion ->openFile($this->filePath );
        $convertExtension = '';
        $fileName = strtolower(str_replace(' ', '_', $this->music->name)).'_'.$this->music->id;
        switch($this->extension)
        {
            case 'aac':
                $this->videoConversion
                ->convertToMp3($fileName);
                $convertExtension = 'mp3';
            break;
            case 'mp3':
                $this->videoConversion->convertToAac($fileName);
                $convertExtension = 'aac';

            break;
            default:
            return 'not found';
        }
        $this->music->{$convertExtension} = "music/$convertExtension/$fileName.$convertExtension";
        $this->music->save();
    }

    /**
     *
     */
    public function convertToExtension($convertExtension)
    {
        // $filePath = $this->music->{$this->extension};

        $this->videoConversion
              ->convertTo{$convertExtension}($this->music->name);
    }

      /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        dd('dfd');
    }

}
