<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Follow;
use Inertia\Inertia;
use App\Services\FollowService;
use App\Services\PostService;
use App\Services\ImageService;
use App\Services\UserService;

class FollowController extends Controller
{
    private $followService;
    private $userService;
    private $postService;

    public function __construct()
    {
        $this->followService = new FollowService();
        $this->userService = new UserService();
        $this->postService = new PostService();
    }


    public function store(Request $request)
    {
        return $this->followService->followUser($request->userId);
    }

    public function check(Request $request)
    {
        return $this->followService->followcheck($request->userId);
    }

    public function followingAmount(Request $request)
    {
        return Follow::where('following_user_id',$request->userId)
                ->count();
    }

    public function followerAmount(Request $request)
    {
        return Follow::where('followed_user_id',$request->userId)
                ->count();
    }

    public function destroy(Request $request)
    {   
        $authUser = User::findOrFail(Auth::id());
        if($authUser->follows()->where('followed_user_id',$request->userId)) {
            $authUser->follows()->detach($request->userId);
        }
        return;
    }

    public function getfollowingList(Request $request)
    {
        $followingUsers = $this->followService->getFollowings($request->userId);

        \Log::debug('followingUsers',[($followingUsers)]);

        return Inertia::render('Users/FollowingList',[
            'followingUsers' => $followingUsers,
            'auth' => User::findOrFail(Auth::id())
        ]);
    }

    public function getfollowerList(Request $request)
    {
        $followerUsers = $this->followService->getFollowers($request->userId);

        \Log::debug('followingUsers', [($followerUsers)]);

        return Inertia::render('Users/FollowerList',[
            'followerUsers' => $followerUsers,
            'auth' => User::findOrFail(Auth::id())
        ]);
    }
}
