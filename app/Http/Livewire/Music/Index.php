<?php

namespace App\Http\Livewire\Music;

use App\Models\Music;
use Livewire\Component;
use Livewire\WithPagination;


class Index extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
//pa make:livewire Music/Index

//    public $musics;
//
//    public function mount()
//    {
//        $this->musics = Music::with('section')->paginate(10)->get();
//    }

 public function destroy($id)
 {
     if($id) {
         Music::destroy($id);
         session()->flash('message', 'Post Deleted Successfully.');
     }
 }
    public function render()
    {
        return view('livewire.music.index',[
            'musics' => Music::with('section')->orderBy('id', 'desc')->paginate(10)
        ]);
    }
}
