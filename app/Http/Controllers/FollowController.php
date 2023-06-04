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
        // $authUser = User::findOrFail(Auth::id());
        // if($authUser->isFollowing($request->userId)){   //　既にフォローしている場合の処理
        //     $authUser->follows()->detach($request->userId); // フォロー解除
        // } else {
        //     $authUser->follows()->attach($request->userId);
        // }
        return $this->followService->followUser($request->userId);
    }

    public function check(Request $request)
    {
        // $authUser = User::findOrFail(Auth::id());
        // if($authUser->isFollowing($request->userId)){
        //     return true;
        // } else {
        //     return false;
        // }
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
        // $user = User::findOrFail($request->userId);

        // $followings = Follow::where('following_user_id',$request->userId)
        //             ->select('followed_user_id')
        //             ->get();
        
        // $followingUsers = collect();
        // foreach($followings as $following) {
        //     $followingUser = User::findOrFail($following);
        //     $followingUsers->push($followingUser);
        // }
        $followingUsers = $this->followService->getFollowings($request->userId);

        \Log::debug('followingUsers',[($followingUsers)]);

        return Inertia::render('Users/FollowingList',[
            'followingUsers' => $followingUsers,
            'auth' => User::findOrFail(Auth::id())
        ]);
    }

    public function getfollowerList(Request $request)
    {
        // $followers = Follow::where('followed_user_id',$request->userId)
        //             ->select('following_user_id')
        //             ->get();
        
        // $followerUsers = [];
        // foreach($followers as $follower) {
        //     $followerUser = User::findOrFail($follower);
        //     // $followingUsers->push($followingUser);
        //     array_push($followerUsers, $followerUser);
        // }
        $followerUsers = $this->followService->getFollowers($request->userId);

        \Log::debug('followingUsers', [($followerUsers)]);

        return Inertia::render('Users/FollowerList',[
            'followerUsers' => $followerUsers,
            'auth' => User::findOrFail(Auth::id())
        ]);
    }
}
