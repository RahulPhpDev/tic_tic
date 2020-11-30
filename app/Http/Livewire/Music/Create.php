<?php

namespace App\Http\Livewire\Music;

use App\Models\Music;
use App\Models\Section;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Jobs\ProceesMp3ToAac;

class Create extends Component
{
    use WithFileUploads;

    public $name;

    public $description;

    public $section_id; // property value

    public $file;

    public $updateMode = false;
    public $inputs = [1];
    public $i = 1;
    // public $sections; // get as params


    // public function updatedFile()
    // {
    //     $this->validate([
    //         'file.*' => 'file|mimes:mp3,aac|max:1024*5',
    //     ]);
    // }

    protected  $rules = [
      'name.*' => 'required|min:3',
      'description.*' => 'required',
      'section.*' => 'required',
      'file.*' => 'required|max:1024'
    ];


    public function saveContact()
    {
       $data = $this->validateFormData();

       foreach($this->name as $key => $res) {
            $array =  [
                'name' => $this->name[$key],
                'description' => $this->description[$key],
                'section_id' => $this->section_id[$key],
            ];
            $music = Music::create( $array );
            $ex = $this->file[$key]->getClientOriginalExtension();
            $imageName = strtolower(str_replace(' ', '_', $music->name)).'_'.$music->id.'.'.$ex;
            $this->file[$key]->storeAs("music/$ex/", $imageName );
            $music->thumb = $imageName;
            $music->{$ex} = "music/$ex/".$imageName;
            ProceesMp3ToAac::dispatch($music, $ex);
            $music->save();
       }
        // $music = Music::create($data);
        // $ex = $this->file->getClientOriginalExtension();
        // $imageName = strtolower(str_replace(' ', '_', $music->name)).'_'.$music->id.'.'.$ex;
        // $this->file->storeAs("music/$ex/", $imageName );
        // $music->thumb = $imageName;
        // $music->{$ex} = "music/$ex/".$imageName;
        // ProceesMp3ToAac::dispatch($music, $ex);
        // $music->save();
        return redirect()->route('admin.music.index');
    }

    public function validateFormData()
    {
        // 'name.*' => 'required|min:3',
        // 'description.*' => 'required',
        // 'section.*' => 'required',
        // 'file.*' => 'required|max:1024'
       return $this->validate(
        [
            'name.0' => 'required',
            'description.0' => 'required',
            'section_id.0' => 'required',
            'file.0' => 'file|mimes:mp3,aac|max:1024*5',


            'name.*' => 'required',
            'description.*' => 'required',
            'section_id.*' => 'required',
            'file.*' => 'file|mimes:mp3,aac|max:1024*5',
        ],
        [
            'name.0.required' => 'name field is required',
            'description.0.required' => 'description field is required',
            'section_id.0.required' => 'section field is required',
            'file.0.required' => 'file field is required',

            'name.*.required' => 'name field is required',
            'description.*.required' => 'description field is required',
            'section_id.*.required' => 'section field is required',
            'file.*.required' => 'file field is required'
        ]
       );
    //    $result = array_merge($data ,
    //      ['section_id' => $data['section'] ]
    //     );
    //    return collect($data)->only('name', 'description', 'section_id')->toArray();
    }


    public function addMore($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function render()
    {
        return view('livewire.music.create', [
          'sections' => Section::pluck('name', 'id'),
        ]);
    }
}
