<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employment;
use App\Models\Location;
use App\Models\User;

class EmploymentController extends Controller
{
    public function __construct()
    {
        // 未ログインはsigninにリダイレクト
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $employments = Employment::query();
        $keyword     = $request->input('keyword');

        if(!empty($keyword)) {
            $spaceConversion = mb_convert_kana($keyword, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) {
                $employments
                ->where('name', 'LIKE', "%{$value}%");
            }
            $keyword = implode(' ', $wordArraySearched);
        }

        return view('employment.index', [
            'employments' => $employments->orderBy('created_at', 'desc')->paginate(10),
            'users'       => User::all(),
            'keyword'     => $keyword,
        ]);
    }

    protected function ajax(Request $request)
    {
        $id = $request->val;
        $employment = Employment::find($id);
        return response()->json($employment);
    }

    public function update(Request $request)
    {
        $department = new Employment();

        $request->validate([
            'name' => ['required','max:50'],
            'note' => ['nullable','max:5000'],
        ]);

        // requestの書き換え
        if(!$request->status){
            $request->merge(['status' => 'D']);
        } else {
            $request->merge(['status' => 'E']);
        }

        Employment::updateOrCreate(
            ['id' => $request->id],
            $request->all()
        );

        return redirect('/employment')->with('flash.success','雇用情報を登録しました');
    }
}
