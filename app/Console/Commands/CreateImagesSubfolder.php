<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CreateImagesSubfolder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:folder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Custom Images Folder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       // let's make the folder here

       // lets make the filter folder

       $folders = [
           'filter' => [ 'file', 'thumbnail' ],
           'test' => [ 'testf', 'testhh' ],
           ];

          array_map( function ($folder, $key) {
            Storage::makeDirectory($key);
            foreach($folder as $fol) {
                Storage::makeDirectory($key.'/'. $fol);
            }
           }, $folders, array_keys($folders));

    }
}
