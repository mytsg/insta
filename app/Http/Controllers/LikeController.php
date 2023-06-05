<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Services\FollowService;
use App\Services\PostService;
use App\Services\ImageService;
use App\Services\UserService;

class LikeController extends Controller
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
        $post = Post::findOrFail($request->post);

        $this->postService->storeLike($post);

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
