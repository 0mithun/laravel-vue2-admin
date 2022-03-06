<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $fileName = md5(time()).'.'.$request->file('image')->extension();

        return Storage::disk('public')->putFileAs('images',$request->file('image'), $fileName);
    }
}
