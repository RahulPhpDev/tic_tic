<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('section-music/{fbId?}', 'MusicController@index');
Route::get('category', 'CategoryController@index');
Route::get('category/detail/{id}', 'CategoryController@detail');

Route::get('filter/detail/{id}', 'FilterController@detail');


Route::get('music/favorites/{userFbId}', 'MusicController@userFavoriteMusic');
Route::get('music/videos/{musicId}', 'MusicController@musicVideos');

Route::get('discover', 'DiscoverController@index');



Route::get('detail/{fbId}', 'UserController@detail');
Route::get('followers/{fbId}', 'UserController@followers');
Route::get('follow/{fbId}', 'UserController@follow');


Route::get('video-comment/{videoId}', 'VideoController@videoComment');
Route::get('videos/{page?}', 'VideoController@index');
Route::get('video/details/{videoId?}', 'VideoController@details');
Route::get('my-videos/{fbId}', 'VideoController@userVideos');
Route::post('video/create', 'VideoController@create');
Route::get('video/liked/{userFbId}', 'VideoController@userLikedVideos');
Route::get('user-info/{fbId}/{loggedInUserFbId?}', 'UserController@userInfo');

//Route::group('prefix')
Route::group( [
    'middleware'  => 'jsonRequestConvertMiddleware'
], function() {

    Route::post('signup', 'RegisterController@signup');
    Route::post('music/favorites', 'MusicController@favorites');
    Route::get('music/search', 'MusicController@search');

    Route::post('user/update', 'UserController@update');
    Route::post('video/comment', 'VideoController@comment');
    Route::post('video/likeDislikeVideo', 'VideoController@likeDislikeVideo');
    Route::post('video/view', 'VideoController@view');

    Route::post('follow-user/{fbId}',  'UserController@followUser');
    Route::post('unfollow-user/{fbId}', 'UserController@unfollowUser');
    Route::get('video/search', 'VideoController@search');

    Route::post('otp/create', 'OtpController@create')->withoutMiddleware(['jsonRequestConvertMiddleware']);
    Route::post('otp/verify', 'OtpController@verify')->withoutMiddleware(['jsonRequestConvertMiddleware']);
    Route::post('otp/resend', 'OtpController@create')->withoutMiddleware(['jsonRequestConvertMiddleware']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
