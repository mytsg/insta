<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $post = Post::findOrFail($request->post);
        $user = Auth::user();
        if($post->isLiked(Auth::id())) {  // ログインユーザーが既にいいねしているかチェック
            // 対象のレコードを取得して削除する
            $deleteRecord = $post->getLike($user->id);
            $deleteRecord->delete();
        } else {
            $like = Like::firstOrCreate([
                'user_id' => Auth::id(),
                'post_id' => $post->id,
            ]);
        }

        $likesAmount = Like::where('post_id',$request->post)
                        ->count();

        return $likesAmount;
    }

    public function check(Request $request)
    {
        $post = Post::findOrFail($request->post);
        if($post->isLiked(Auth::id())){
            return true;
        } else {
            return false;
        }
    }
}
