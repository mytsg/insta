<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use InterventionImage;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // dd($request);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'userName' => 'required|string|max:255|unique:users',
            'icon' =>'' , //写真を登録できるように
            'profile' => 'string|max:255|',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // $imageFile = $request->icon;

        // // dd($imageFile);

        // if($imageFile->isValid()){
        //     $fileName = uniqid(rend().'_');
        //     $extension = $imageFile->extension();
        //     $fileNameToStore = $fileName.'.'.$extension;
        //     $resizedImage = InterventionImage::make($imageFile)->resize(1920,1920)->encode();

        //     Storage::put('public/shops/'.$fileNameToStore, $resizedImage);
        // }

        // dd($resizedImage);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'userName' => $request->userName,
            // 'icon' => $fileNameToStore,
            'profile' => $request->profile,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
