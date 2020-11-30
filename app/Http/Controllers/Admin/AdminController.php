<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public  function index()
    {
        return view('admin.home');
    }


    public function section()
    {
        return view('admin/section');
    }

    public function category()
    {
        return view('admin.category');
    }

    public function filter()
    {
        return view('admin.filter');
    }
}
