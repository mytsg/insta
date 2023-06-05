<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Follow;

class FollowService
{
    public function followUser($userId)
    {
        $authUser = User::findOrFail(Auth::id());
        if($authUser->isFollowing($userId)){   //　既にフォローしている場合の処理
            $authUser->follows()->detach($userId); // フォロー解除
        } else {
            $authUser->follows()->attach($userId);
        }
        return;
    }

    public function followcheck($userId)
    {
        $authUser = User::findOrFail(Auth::id());
        if($authUser->isFollowing($userId)){
            return true;
        } else {
            return false;
        }
    }

    public function getFollowings($userId)
    {
        $followings = Follow::where('following_user_id',$userId)
                    ->select('followed_user_id')
                    ->get();
        
        $followingUsers = collect();
        foreach($followings as $following) {
            $followingUser = User::findOrFail($following);
            $followingUsers->push($followingUser);
        }

        return $followingUsers;
    }

    public function getFollowers($userId)
    {
        $followers = Follow::where('followed_user_id',$userId)
                    ->select('following_user_id')
                    ->get();
        
        $followerUsers = [];
        foreach($followers as $follower) {
            $followerUser = User::findOrFail($follower);
            array_push($followerUsers, $followerUser);
        }

        return $followerUsers;
    }
}