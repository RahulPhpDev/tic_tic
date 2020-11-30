<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Hash;
class LoginController extends Controller
{


    protected $redirectTo = '/admin/user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout','create']]);
    }


    public function create(Request $request)
    {
        return view('auth/login');
    }

    public function login(Request $request)
    {
       $this->validate($request, [
           'email' => 'required|email',
           'password' => 'required'
       ]);
     $credential = $request->only('email', 'password');
     if (Auth::attempt($credential,  $request->remember) )
     {
        return redirect($this->redirectTo);
     }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
