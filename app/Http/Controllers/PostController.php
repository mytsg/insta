<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use InterventionImage;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Services\FollowService;
use App\Services\PostService;
use App\Services\ImageService;
use App\Services\UserService;

class PostController extends Controller
{
    private $followService;
    private $userService;
    private $postService;
    private $imageService;

    public function __construct()
    {
        $this->followService = new FollowService();
        $this->userService = new UserService();
        $this->postService = new PostService();
        $this->imageService = new ImageService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allPosts = Post::with('user')
                    ->with('comments')
                    ->with('likes')
                    ->orderBy('created_at', 'desc')
                    ->get();

        $authUser = User::findOrFail(Auth::id());

        return Inertia::render('Posts/Index',[
            'posts' => $allPosts,
            'authUser' => $authUser,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        // dd($request);

        $userId = Auth::id();

        $imageFile = $request->filename;

        $fileNameToStore = $this->imageService->resizeImage($imageFile, 1920, 1920, 'public/posts/');

        $post = Post::create([
            'content' => $request->content,
            'filename' => $fileNameToStore,
            'user_id' => $userId,
        ]);

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
