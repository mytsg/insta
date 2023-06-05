<?php

namespace App\Services;

use IntervintionImage;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use InterventionImage;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ImageService
{
    public function resizeImage($imageFile, $width, $height, $path)
    {
        if(!is_null($imageFile) && $imageFile->isValid()){
            $fileName = uniqid(rand().'_');
            $extension = $imageFile->extension();
            $fileNameToStore = $fileName.'.'.$extension;
            $resizedImage = InterventionImage::make($imageFile)->resize($width,$height)->encode();

            Storage::put($path.$fileNameToStore, $resizedImage);
        
            return $fileNameToStore;
        }
    }
}