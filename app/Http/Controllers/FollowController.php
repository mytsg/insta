<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FollowController extends Controller
{
    public function store(Request $request)
    {
        $authUser = User::findOrFail(Auth::id());
        if($authUser->isFollowing($request->userId)){   //　既にフォローしている場合の処理
            \Log::debug('controller フォローしています',[($request->userId)]);
            $authUser->follows()->detach($request->userId); // フォロー解除
        } else {
            \Log::debug('controller フォローしていません',[($request->userId)]);
            $authUser->follows()->attach($request->userId);
        }
        return;
    }

    public function check(Request $request)
    {
        $authUser = User::findOrFail(Auth::id());
        if($authUser->isFollowing($request->userId)){
            \Log::debug('followチェック true');
            return true;
        } else {
            \Log::debug('followチェック else');
            return false;
        }
    }

    public function destroy(Request $request)
    {   
        $authUser = User::findOrFail(Auth::id());
        if($authUser->follows()->where('followed_user_id',$request->userId)) {
            $authUser->follows()->detach($request->userId);
        }
        return;
    }
}
