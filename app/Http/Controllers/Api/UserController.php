<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\User;
use Illuminate\Http\Request;
use DB;
class UserController extends Controller
{

    /**
     * p = get_user_data
     * @param $fbId
     * @return Response
     */
    public function detail($fbId)
    {
        $user = User::where('fb_id', $fbId)->withCount(['userVideosLike', 'follow', 'follower', 'likedVideos'])->first();
        return response(['msg' => [$user]]);
    }

    /**
     * edit_profile
     *
     */
    public function update(Request $request)
    {
        $this->validate($request, ['fb_id' => 'required|exists:users']);
        $input = $request->only(
            'first_name',
            'last_name',
            'gender',
            'bio',
            'username'
        );
        $user = User::userByFbId($request->fb_id);
        $user->update(
            $input
        );
        return (new UserResource($user->first()))->response()->setStatusCode(200);
    }

    /**
     *$_GET["p"]=="get_followers"
     */
    public function followers($fbId)
    {
        $user = User::with('follower')->where('fb_id', $fbId)->first();

        $follow = count($user->follower) ?  1 : 0;
        $follow_status_button = count($user->follower) ?  'Unfollow' : 'Follow';
        $user->unsetRelation('follower');
        return response(['msg' => [[
            $user,
            'follow_status' => [
                'follow' => $follow,
                'follow_status_button' => $follow_status_button,
            ]
        ]]]);
    }

    /**
     * get_followings
     */
    public function follow($fbId)
    {
        $user = User::with('follow')->where('fb_id', $fbId)->first();

        $follow = count($user->follower) ?  1 : 0;
        $follow_status_button = count($user->follower) ?  'Unfollow' : 'Follow';
        $user->unsetRelation('follower');
        return response(['msg' => [[
            $user,
            'follow_status' => [
                'follow' => $follow,
                'follow_status_button' => $follow_status_button,
            ]
        ]]]);
    }

    /**
     * Request $request
     * user.fb_id $fbId
     *
     */
    public function followUser(Request $request, $fbId)
    {
        $followUser = User::
                    select(['id', 'first_name', 'last_name', 'fb_id'])
                    ->UserByFbId($request->fb_id);

        $user = User::UserByFbId($fbId);
        if ( !  $user->follow->contains($followUser) )
        {
            $user->follow() ->attach($followUser);
        }
        // put value at once only

        return response(
            [
                'msg' => [
                    $followUser,
                    'follow_status' => [
                        'follow' => 'UnFollow',
                        'follow_status_button' => 1,
                    ]
                ]
            ]
        );
    }

    /**
     * UnFollow the user
     */

     public function unfollowUser(Request $request, $fbId)
     {
        $followUser = User::
                    select(['id', 'first_name', 'last_name', 'fb_id'])
                    ->UserByFbId($request->fb_id);
            $user =  User::UserByFbId($fbId);
            if (  $user->follow->contains($followUser) )
            {
                $user->follow() ->detach($followUser);
            }


        // put value at once only

        return response(
            [
                'msg' => [
                    $followUser,
                    'follow_status' => [
                        'follow' => 'Follow',
                        'follow_status_button' => 0,
                    ]
                ]
            ]
        );
     }

     public function userInfo(Request $request, $fbId,$loggedInUserFbId )
     {
        $loggedInUserID = User::where('fb_id',$loggedInUserFbId)->first()->id;
        $info = User::withCount(['follow', 'follower','video','likedVideos'])
        ->with(['follow' => function ($query) use ( $loggedInUserID) {
            $query->where( 'user_id',$loggedInUserID);
        }])
        ->userByFbId($fbId);

       $info['follow_status'] =   $info->follow->isNotEmpty();
       $info->unsetRelation('follower')->unsetRelation('follow');
        return response()->json(
             $info,
             200
        );
     }
}
