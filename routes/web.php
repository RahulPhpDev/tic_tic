<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   return redirect('admin/login');
//    ->url('admin/login');
});
Route::any('/test', 'TestController@test');

// Route::post('test', 'TestController@create')->middleware('jsonApiMiddleware');
Route::get('admin/login', 'LoginController@create');
Route::post('/admin/login', 'LoginController@login')->name('login');
Route::get('/admin/logout', 'LoginController@logout')->name('logout');

Route::group([
    'name' => 'admin.',
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => 'admin',
], function () {
    Route::get('/home',function (){
        return redirect('admin/user');
    })->name('home');

    Route::name('admin.') ->group( function () {
        Route::get('/section', 'AdminController@section')->name('section');
        Route::resource('music', 'MusicAdminController');
        Route::resource('user', 'UserController');
        Route::get('video', 'VideoController@index')->name('video');
        Route::get('filter', 'AdminController@filter')->name('filter');
        Route::get('category', 'AdminController@category')->name('category');
    });

});
