<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'filename',
    ];

    // protected $appends = [
    //     'likes_count', 'liked_by_user',
    // ];

    // // リレーションシップ - usersテーブル
    // public function likes()
    // {
    //     return $this->belongsToMany('App\Models\User','likes')
    //     ->withTimestamps();
    // }
    
    // /**
    // * アクセサ - likes_count
    // * @return integer
    // */
    // public function getLikesCountAttribute()
    // {
    //     return $this->likes->count();
    // }

    // /**
    //  * そのコメントにログインユーザー（プロフィール）がすでにいいねをおしているかチェック
    //  * アクセサ - liked_by_user
    //  * @return boolean
    //  */
    // public function getLikedByUserAttribute()
    // {
    //     if(Auth::guest()){
    //         return false;
    //     }

    //     return $this->likes->contains(function ($user) {
    //         return $user->id === Auth::user()->id;
    //     });
    // }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLiked($userId)
    {
        return $this->likes()->where('user_id',$userId)->exists();
    }

    public function getLike($userId)
    {
        $like = $this->likes()->where('user_id',$userId)->first();
        \Log::debug('like',[($like)]);
        return $like;
    }
}
