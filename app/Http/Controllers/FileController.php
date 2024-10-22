<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FileController extends Controller
{
    public function publicNoid(Request $request, $page = '', $path = '')
    {
        if($path === '') abort(404);

        $rp = storage_path('app/public/'.$page.'/'.$path);
        if(File::exists($rp)){
            return response()->file($rp);
        }else{
            abort(404);
        }
    }

    public function public(Request $request, $page = '', $id = '', $path = '')
    {
        if($path === '') abort(404);

        $rp = storage_path('app/public/'.$page.'/'.$id.'/'.$path);
        if(File::exists($rp)){
            return response()->file($rp);
        }else{
            abort(404);
        }
    }

    public function protected(Request $request, $page = '', $id = '', $path = '')
    {
        if($path === '') abort(404);

        $rp = storage_path('app/protected/'.$page.'/'.$id.'/'.$path);
        if(File::exists($rp)){
            return response()->file($rp);
        }else{
            abort(404);
        }
    }
}
