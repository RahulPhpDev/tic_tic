<?php

namespace App\Http\Livewire\Admin\Section;

use Livewire\Component;
use App\Models\Section as SectionModel;

class Section extends Component
{
    public $sections;
    
    public $name;
    
    public $section_id;

    protected $rules = [
        'name' => 'required',
    ];



    public function resetInputFields()
    {
            $this->name = '';
    }


    public function store()
    {
            $data = $this->validateFormData();
            SectionModel::insert($data);
            session()->flash('message', 'Data Created Successfully.');
            $this->resetInputFields();
            $this->emit('dataStore');

    }

    public function edit($id)
    {
        $section = SectionModel::findOrFail($id);
        $this->section_id = $id;
        $this->name = $section->name;

    }

    public function update()
    {
        $data = SectionModel::find($this->section_id);

        $data->update([
            'name'       =>   $this->name,
        ]);
        
        session()->flash('message', 'Data Created Successfully.');
        $this->resetInputFields();
        $this->emit('dataStore');
    }

    public function validateFormData()
    {
      return $this->validate();
      
    }

    public function destroy($id)
        {
            if($id) {
                SectionModel::destroy($id);
                  session()->flash('message', 'Data Delete Successfully.');
            }
    }

    public function render()
    {
        $this->sections = SectionModel::all();
        return view('livewire.admin.section.index');
    }
}