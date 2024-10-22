<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Process;
use Illuminate\Http\Request;
use App\Models\Config;

class ConfigController extends Controller
{
    public function __construct()
    {
        // 未ログインはsigninにリダイレクト
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $config = Config::find(1);

        return view('config.index', [
            'config' => $config,
        ]);
    }

    public function store(Request $request)
    {
        $this->check($request);

        // requestの書き換え
        if(!$request->mm_status){
            $request->merge(['mm_status' => 'D']);
        } else {
            $request->merge(['mm_status' => 'E']);
        }
        $config = new Config();

        $inputs = $request->all();

        $config = Config::updateOrCreate(
            ['id' => 1],
            $inputs
        );

        return redirect('/config')->with('flash.success','コンフィグを更新しました');
    }

    protected function check(Request $request)
    {
        $credentials = $request->validate(Config::RULES);

        return null;
    }
}
