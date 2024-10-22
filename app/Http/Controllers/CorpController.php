<?php

namespace App\Http\Controllers;

use App\Models\Corp;
use App\Models\Department;
use Illuminate\Http\Request;

class CorpController extends Controller
{
    public function __construct()
    {
        // 未ログインはsigninにリダイレクト
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $corps = Corp::query();
        $keyword = $request->input('keyword');
        $status  = $request->input('status');

        if(!empty($status)) {
            $corps = Corp::query();
        } else {
            $corps = Corp::query()->where('status','E');// 初期ページでは有効のみ
        }

        if(!empty($keyword)) {
            $spaceConversion = mb_convert_kana($keyword, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) {
                $corps
                ->where('name', 'LIKE', "%{$value}%");
            }
            $keyword = implode(' ', $wordArraySearched);
        }

        return view('corp.index', [
            'corps'       => $corps->paginate(10),
            'keyword'     => $keyword,
            'departments' => Department::all(),
            'status'      => $status,
        ]);
    }

    protected function ajax(Request $request)
    {
        $id   = $request->val;
        $corp = Corp::find($id);

        return response()->json($corp);
    }

    public function update(Request $request)
    {
        $corp = new Corp();

        $corp = $request->validate(Corp::rules());

        // requestの書き換え
        if(!$request->status){
            $request->merge(['status' => 'D']);
        } else {
            $request->merge(['status' => 'E']);
        }

        Corp::updateOrCreate(
            ['id' => $request->id],
            $request->all()
        );

        return redirect('/corp')->with('flash.success','企業情報を登録しました');
    }
}
