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
