<?php

namespace App\Http\Livewire\Admin\User;

use Livewire\Component;
use App\User as UserModel;
use Illuminate\Support\Str;
use Livewire\WithPagination;
class User extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $user;

    public $detail;

    public $first_name;

    public $last_name;

    public $email;

    public $gender;

    public $user_id;

    public $countType;

    public $editId;

    protected $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'email|required',
        'gender' => 'required'
    ];



    public function resetInputFields()
    {
            $this->first_name = '';
            $this->last_name ='';
            $this->email ='';
            $this->gender = '';
            $this->editId = '';
    }


    public function store()
    {
            $data = $this->validateFormData();
            UserModel::insert($data);
            session()->flash('message', 'Data Created Successfully.');
            $this->resetInputFields();
            $this->emit('dataStore');

    }


    public function validateFormData()
    {
       $data = $this->validate();
       $result = array_merge($data , ['password' =>  12345, 'fb_id' =>  Str::uuid(), 'username' => $this->first_name.rand() ]);
       return collect($result)->only('first_name', 'last_name','email', 'gender', 'password', 'fb_id', 'username')->toArray();
    }

    public function destroy($id)
        {
            if($id) {
                UserModel::destroy($id);
                  session()->flash('message', 'Data Delete Successfully.');
            }
    }

    public function edit($id):Void
    {
        if($id) {
            $user =   UserModel::findOrFail($id);
            $this->first_name = $user->first_name;
            $this->last_name =$user->last_name;
            $this->email =$user->email;
            $this->gender = $user->gender;
            $this->editId = $id;
        }
    }
    public function update($id):Void
    {
        if($id) {
            $user =   UserModel::findOrFail($id);
            $user->update([
                'first_name'  =>   $this->first_name,
                'last_name'  =>   $this->last_name,
                'gender'  =>   $this->gender,
            ]);

            session()->flash('message', 'Data updated Successfully.');
            $this->resetInputFields();
            $this->emit('dataStore');
        }
    }


    public function detail($id):Void
    {
        if($id) {
            $this->user_id = $id;
            $this->detail =   UserModel::withCount([
                'follow',
                'video',
                'followers'
            ])->findOrFail($id);
        }
    }


    /**
     * Get the Count details
     * and users details
     */
    public function counts( $type)
    {
        if($type) {
            $this->countType = $type;
            $this->detail->load($type)->loadCount([
                'follow',
                'video',
                'followers'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.user.index', [
            'users' =>  UserModel::where('id', '!=', auth()->user()->id)->paginate()
        ]);
    }
}
