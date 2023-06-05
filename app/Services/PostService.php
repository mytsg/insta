<?php

namespace App\Services;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
class PostService
{
    public function storeLike($post)
    {
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
        return;
    }
}