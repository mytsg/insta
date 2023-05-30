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
        if($post->isLiked(Auth::id())) {  // ログインユーザーが既にいいねしておるかチェック
            // 対象のレコードを取得して削除する
            \Log::debug('いいね取り消し');
            $deleteRecord = $post->getLike($user->id);
            $deleteRecord->delete();
        } else {
            $like = Like::firstOrCreate([
                'user_id' => Auth::id(),
                'post_id' => $post->id,
            ]);
            \Log::debug('いいね保存',([$like]));
        }
    }

    public function check(Request $request)
    {
        \Log::debug('チェックします',([$request->post]));
        $post = Post::findOrFail($request->post);
        if($post->isLiked(Auth::id())){
            return 1;
        } else {
            return 2;
        }
    }
}
