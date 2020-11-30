<?php

namespace App\Http\Livewire\Admin\Filter;

use App\Models\Category;
use App\Models\Filter;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Arr;
use App\Enums\FilterEnum;

class FilterController extends Component
{
    use WithPagination,WithFileUploads;
    // protected $listeners = ['postAdded' => 'resetInputFields'];

    protected $paginationTheme = 'bootstrap';
    public $name;
    public $description;
    public $thumb;
    public $file;
    public $image;
    public $disableBtn = false;
    public $filter_id;
    public $cat_id;
    public $section_id;
    public $categories;
    public $filter_photo_id;
    public $photo = '';
    public $type;
    public $filterPhotoPreview;
    public $editImage;


    // public $detail;

    protected $rules = [
        'name' => 'required',
        'description' => 'required',
        // 'thumb' => 'required',
        'cat_id' => 'required'
    ];


    public function resetInputFields()
    {
        $this->name = NULL;
        $this->description = NULL;
        $this->thumb =  NULL;
        $this->filter_id = NULL;
        $this->cat_id = NULL;
        $this->image = NULL;
        $this->editImage = NULL;
        $this->filterPhotoPreview = NULL;
        $this->type = NULL;
    }

    public function photoPreview($id , $type)
    {
        $this->filterPhotoPreview = Filter::findOrFail($id);
        $this->photo =  $this->filterPhotoPreview->{$type};
        $this->filter_photo_id = $id;
        $this->type = $type;
    }

    function updateImage()
    {
        dd($this->{$this->type});
        $thumbName = getThumbnailName($this->filterPhotoPreview->name, $this->filter_photo_id, $this->{$this->type}->getClientOriginalExtension());
        $type = $this->type == 'thumb' ? FilterEnum::THUMB_PATH : FilterEnum::FILE_PATH;
        $this->{$this->type}->storeAs($type, $thumbName);

        $this->filterPhotoPreview->{$this->type} = $thumbName;
        $this->filterPhotoPreview->save();

        $this->filter_photo_id = NULL;
        $this->resetInputFields();
        $this->emit('dataStore');
    }


    public function deleteImage()
    {
           $type = $this->type == 'thumb' ? FilterEnum::THUMB_PATH : FilterEnum::FILE_PATH;
            Storage::delete($type.'/'.$this->filterPhotoPreview->getAttributes()[$this->type] );
            $this->filterPhotoPreview->{$this->type} = NULL;
            $this->filterPhotoPreview->save();
            $this->filter_photo_id = null;
    }

    public function store()
    {
            $data = $this->validate();
            $final = array_merge($data, ['category_id' => $this->cat_id]);
            $filter = Filter::create($final);
            $thumbName = getThumbnailName($this->name, $filter->id, $this->thumb->getClientOriginalExtension());

            $fileExt = $this->file ? $this->file->getClientOriginalExtension() : NULL;
            $fileName = getThumbnailName($this->name, $filter->id, $fileExt);

            $this->thumb->storeAs(FilterEnum::THUMB_PATH, $thumbName);
            $this->file->storeAs(FilterEnum::FILE_PATH, $fileName);

            $filter->thumb = $thumbName;
            $filter->file = $fileName;
            $filter->save();

            session()->flash('message', 'Data Created Successfully.');
            $this->resetInputFields();
            $this->emit('dataStore');

    }


    public function delete($id)
    {
        if($id) {
            $filter = Filter::findOrFail($id);
            Storage::delete(FilterEnum::FILE_PATH.'/'.$filter->getAttributes()['file']);
            Storage::delete(FilterEnum::THUMB_PATH.'/'.$filter->getAttributes()['thumb']);
            $filter->destroy($id);
            session()->flash('message', 'Video Deleted Successfully.');
            $this->resetInputFields();
            $this->emit('dataStore');
        }
    }

    public function edit($id)
    {
        $this->filter_id = $id;
        $detail = Filter::findOrFail($id);
        $this->name = $detail->name;
        $this->description =  $detail->description;
        $this->thumb =    $detail->description;
        $this->cat_id = $detail->category_id;
    }

    public function update()
    {
        if($this->filter_id) {
            $filter = Filter::findOrFail($this->filter_id);
            $filter->name = $this->name;
            $filter->description = $this->description;
            $filter->category_id = $this->cat_id;
            $filter->save();
            session()->flash('message', 'Updated Successfully.');
            $this->resetInputFields();
            $this->emit('dataStore');
        }
    }

    public function render()
    {
        $this->categories = Category::pluck('title', 'id');
        return view('livewire.admin.filter.index', [
            'filters' => Filter::with('category')->paginate(),
            // 'cats' => Category::pluck('title', 'id'),
        ]);
    }
}
