<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follow;
use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use InterventionImage;
use Illuminate\Support\Facades\Storage;
use App\Services\FollowService;
use App\Services\PostService;
use App\Services\ImageService;
use App\Services\UserService;

class UserController extends Controller
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
    public function index(Request $request)
    {
        $users = User::searchUsers($request->search)
                ->where('id','<>',Auth::id())
                ->get();


        $authUser = User::findOrFail(Auth::id());

        return Inertia::render('Users/Index',[
            'users' => $users,
            'authUser' => User::findOrFail(Auth::id()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = Post::with('comments')
                ->with('user')
                ->where('user_id',$id)
                ->get();
        $following = Follow::where('following_user_id',$id)
                ->count();
        $follower = Follow::where('followed_user_id',$id)
                ->count();

        if($id != Auth::id()) {
            return Inertia::render('Users/Show',[
                'user' => $user,
                'posts' => $posts,
                'amount' => $posts->count(),
                'following' => $following,
                'follower' => $follower
            ]);
        } else {
            return Inertia::render('Users/MyProfile',[
                'user' => $user,
                'posts' => $posts,
                'amount' => $posts->count(),
                'following' => $following,
                'follower' => $follower
            ]);
        }
    }

    public function myProfile()
    {
        $id = Auth::id();
        $user = User::findOrFail($id);

        $posts = Post::with('user')
                ->with('comments')
                ->where('user_id',$id)
                ->get();
        $following = Follow::where('following_user_id',$id)
                ->count();
        $follower = Follow::where('followed_user_id',$id)
                ->count();
    
        return Inertia::render('Users/MyProfile',[
            'user' => $user,
            'posts' => $posts,
            'amount' => $posts->count(),
            'following' => $following,
            'follower' => $follower
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if($user == Auth::user()){
            return Inertia::render('Users/Edit',[
                'user' => $user
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $imageFile = $request->icon;

        $fileNameToStore = $this->imageService->resizeImage($imageFile, 1920, 1920, 'public/icons/');

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->userName =$request->userName;
        $user->profile = $request->profile;
        $user->icon = $fileNameToStore;
        $user->save();

        return redirect()->route('myprofile')
        ->with([
            'user' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
