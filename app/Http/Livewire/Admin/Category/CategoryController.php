<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;;
use Livewire\WithFileUploads;

class CategoryController extends Component
{
    use WithPagination,WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $title;
    public $disableBtn = false;
    public $category_id = null;
    protected $rules = [
        'title' => 'required',
    ];

    public function resetInputFields()
    {
        $this->title = NULL;
    }

    public function store()
    {
            $data = $this->validate();
            $category = Category::create($data);
            $category->save();

            session()->flash('message', 'Data Created Successfully.');
            $this->resetInputFields();
            $this->emit('dataStore');

    }


    public function delete($id)
    {
        if($id) {
            $category = Category::findOrFail($id);
            $category->destroy($id);
            session()->flash('message', 'Data Deleted Successfully.');
            $this->resetInputFields();
            $this->emit('dataStore');
        }
    }

    public function edit($id)
    {
        $this->category_id = $id;
        $category = Category::findOrFail($id);
        $this->title = $category->title;
    }

    public function update()
    {
        if($this->category_id) {
            $category = Category::findOrFail($this->category_id);
            $category->title = $this->title;
            $category->save();
            session()->flash('message', 'Updated Successfully.');
            $this->resetInputFields();
            $this->emit('dataStore');
        }
    }

    public function render()
    {
        return view('livewire.admin.category.index',[
            'categories' => Category::withCount('filter')->paginate(),
        ]);
    }
}
