<?php

namespace App\Http\Livewire\Admin\Video;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Video as VideoModel;
use App\Models\Section;
use App\Models\Music;
use Auth;
use Livewire\WithFileUploads;
use App\Jobs\PorcessUploadAdminVideoJob;

class Video extends Component
{
    use WithPagination,WithFileUploads;

    protected $paginationTheme = 'bootstrap';

// user_id
// section_id
// description
// video
// thum
// gif
// music_id
    public $video_id;


    public $music_id;

    public $section_id;

    public $user_id;

    public $description;

    public $video;

    public $disableBtn = false;

    public $detail;


    protected $rules = [
        'section_id' => 'required',
        'music_id'=> 'required',
        'description' => 'required',
        'video' =>  'required|mimes:mp4,ogg,m4v|max:10024'
    ];

    // #real time valiation
    // public function updatedVideo()
    // {
    //     $this->validate([
    //         'video' => 'mimes:mp4||max:10024', // 10MB Max
    //     ]);
    // }

    public function resetInputFields()
    {
        $this->video_id = NULL;
        $this->music_id = NULL;
        $this->section_id =  NULL;
        $this->description = NULL;
    }

    public function store()
    {
        $this->disableBtn = True;
        $data = array_merge(['user_id' => $this->user_id] ,$this->validate() );
        $video =  VideoModel::create($data);
        $videoName = getVideoName(
            $video,
            $this->video->getClientOriginalExtension()
        );
        $videoPath = "videos/video";
        $this->video->storeAs( $videoPath,  $videoName  );
        $video->video =   $videoPath.'/' .$videoName;
        $video->save();
        PorcessUploadAdminVideoJob::dispatch($video);
        $this->resetInputFields();
        $this->emit('dataStore');
        return redirect()->route('admin.video');
    }

    /**
     *
     */
    public function edit($id)
    {
        $video = VideoModel::findOrFail($id);
        $this->video_id = $id;
        $this->music_id =  optional($video->music)->id  ?? NULL;
        $this->section_id =  optional($video->section)->id ?? NULL;
        $this->user_id =  $video->user->id;
        $this->description =  $video->description;

    }


    public function update()
    {
        $data = VideoModel::find($this->video_id);

        $data->update([
            'music_id'  =>   $this->music_id,
            'section_id'  =>   $this->section_id,
            'description'  =>   $this->description,
        ]);

        session()->flash('message', 'Data Update Successfully.');
        $this->resetInputFields();
        $this->emit('dataStore');
    }


    public function delete($id)
    {
        if($id) {
            VideoModel::destroy($id);
            session()->flash('message', 'Video Deleted Successfully.');
        }
    }

    public function details($id)
    {
        $this->video_id = $id;
        $this->detail = VideoModel::findOrFail($id);
        // dd($this->detail);
    }

    public function render()
    {
        $this->user_id = Auth::user()->id;
        return view('livewire.admin.video.index', [
          'videos' =>  VideoModel::with(['music', 'section'])->paginate(),
          'sections' => Section::pluck('name', 'id'),
          'musics' => Music::where('mp3', '!=', NULL)->pluck('name', 'id')
        ]);
    }
}
