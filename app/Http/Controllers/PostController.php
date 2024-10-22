<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Files;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DB;

class PostController extends Controller
{
    public function __construct()
    {
        $this->disk = Storage::disk('public');
    }

    public function upload(Request $request, $url = '')
    {
        $fileName = $request->file('file')->getClientOriginalName();
        if($url == 'profile') {
            $this->disk->putFileAs('/profile/'.Auth::user()->id, $request->file('file'), $fileName);
            $path = '/public/profile/'.Auth::user()->id.'/'.$fileName;
        } else {
            $this->disk->putFileAs('/'.$url.'/', $request->file('file'), $fileName);
            $path = '/public/'.$url.'/'.$fileName;
        }

        return response()->json(['location' => $path]);
    }

    // ファイルをモーダルで表示させるときにファイルデータを表示させる
    public function getfiledata(Request $request)
    {
        $id    = $request->val;
        $datas = Files::find($id);

        // 表示用として新しい項目を追加
        $user  = User::find($datas->register_id);
        $datas['register_name'] = getNamefromUserId($user->id);
        $datas['create_date']   = $datas['created_at']->format('Y/m/d');

        return response()->json($datas);
    }
}
