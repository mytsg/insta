<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'userName',
        'icon',
        'profile',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function follows()   // フォローしているUserを返す
    {
        return $this->belongsToMany(self::class,'follows','following_user_id','followed_user_id')
        ->withPivot('followed_user_id');
    }

    public function isFollowing($followedUserId)
    {
        
        if($this->follows->contains('id',$followedUserId)) {
            return true;
        } else {
            return false;
        }
    }

    public function scopeSearchUsers($query, $search = null)
    {
        if(!empty($search)){
            return $query->where('name','like',"%".$search."%")
            ->orWhere('userName','like',"%".$search."%");
        } else {
            return $query;
        }
    }
}
