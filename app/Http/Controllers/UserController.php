<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use InterventionImage;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Users/Index');
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
        //
    }

    public function myProfile()
    {
        $id = Auth::id();
        $user = User::findOrFail($id);
        return Inertia::render('Users/MyProfile',[
            'user' => $user
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
        // elseの場合に404を投げたい
        // return Inertia::render('Users/Edit');
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
        // dd($request->icon);

        $imageFile = $request->icon;

        // dd($imageFile);

        if(!is_null($imageFile) && $imageFile->isValid()){
            $fileName = uniqid(rand().'_');
            $extension = $imageFile->extension();
            $fileNameToStore = $fileName.'.'.$extension;
            $resizedImage = InterventionImage::make($imageFile)->resize(1920,1920)->encode();

            // dd($fileNameToStore);

            Storage::put('public/icons/'.$fileNameToStore, $resizedImage);
        }

        // dd($fileNameToStore, $resizedImage);

        // $user = User::findOrFail($id)
        //         ->select('id','name','userName','email','icon','profile')
        //         ->get();

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