<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\User;
use App\Models\Admin;
use App\Models\Manual;
use App\Models\Favorite;
use Illuminate\Support\Facades\Gate;

class ManualController extends Controller
{
    public function __construct()
    {
        // 未ログインはsigninにリダイレクト
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $keyword    = $request->input('keyword');
        $manuals    = Manual::query();
        $conditions = [
            'register_id'   => $register_id = $request->input('register_id'),
            'department_id' => $department_id = $request->input('department_id')
        ];

        if(!empty($keyword)) {
            $spaceConversion = mb_convert_kana($keyword, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) {
                $manuals
                ->where('title', 'LIKE', "%{$value}%");
            }
            $keyword = implode(' ', $wordArraySearched);
        }

        foreach($conditions as $col => $val) {
            if(!empty($val)){
                if($col == 'register_id' && $val == Auth::user()->id){
                    $manuals
                    ->where($col, '=', $val);
                } else {
                    $manuals
                    ->where('status', '=', 'E')
                    ->where($col, '=', $val);
                }
            } else {
                // 一覧表示
                $manuals
                ->where(function ($query) {
                    $query
                    ->where('register_id', '=', Auth::user()->id)
                    ->orWhere(function ($query) {
                        $query
                        ->where('register_id', '!=', Auth::user()->id)
                        ->where('status', '=', 'E');
                    });
                });
            }
        }

        $roles   = getArrToRole(array_reverse(Admin::ADMIN_ROLES), Auth::user()->admin->role);
        $manuals = $manuals
                    ->whereIn('role', $roles);

        return view('manual.index', [
            'keyword'         => $keyword,
            'admins'          => getStatusEnable(new Admin),
            'manuals'         => $manuals->orderBy('created_at', 'desc')->paginate(10),
            'register_id_req' => $register_id,
            'department_id'   => $department_id,
        ]);
    }

    public function detail(Request $request, $id = '')
    {
        $manual = new Manual;
        $manual = Manual::find($id);
        if(!$manual) {
            abort(404);
        }
        // 非公開で登録者じゃなければ見せない
        if($manual->status == 'D' && $manual->register_id != Auth::user()->id){
            abort(403);
        }
        $roles = getArrToRole(Admin::ADMIN_ROLES, $manual->role);

        if (Gate::denies('isManualVisible', $manual)) {
            return redirect('/manual')->with('flash.failed','マニュアルの閲覧権限がありません');
        }

        return view('manual.detail', [
            'manual' => $manual,
        ]);
    }

    public function edit(Request $request, $id = '')
    {
        $manual = new Manual;
        $manual = Manual::find($id);

        if($manual) {
            $roles  = getArrToRole(Admin::ADMIN_ROLES, $manual->role);
            $updatable_ids = $manual->updatable_ids.','.$manual->register_id;

            if (Gate::denies('isManualVisible', $manual)) {
                if (Gate::denies('isManualUpdateble', $manual)) {
                    return redirect('/manual')->with('flash.failed','マニュアルの閲覧権限もしくは編集権限がありません');
                }
            } else {
                if (Gate::denies('isManualUpdateble', $manual)) {
                    return redirect('/manual')->with('flash.failed','マニュアルの閲覧権限もしくは編集権限がありません');
                }
            }
        }

        $admins = Admin::query()
                    ->where('status','=','E');

        if($manual) {
            $admins = $admins->where('id','!=',$manual->register_id);
        }

        return view('manual.edit', [
            'manual' => $manual,
            'admins' => $admins->get(),
        ]);
    }

    public function confirm(Request $request)
    {
        $this->check($request);
        $inputs = $request->all();

        return view('manual.confirm', [
            'inputs' => $inputs,
        ]);
    }

    public function store(Request $request, $id = '')
    {
        $this->check($request);
        $manual = new Manual();

        if(!$request->id) {
            // merge
            $request->merge(['register_id' => Auth::user()->id]);
        }
        $inputs = $request->all();

        if($request->id) {
            $manual = Manual::find($request->id);
            $roles  = getArrToRole(Admin::ADMIN_ROLES, $manual->role);
            $updatable_ids = $manual->updatable_ids.','.$manual->register_id;

            if (Gate::denies('isManualUpdateble', $manual)) {
                return back()->with('flash.failed','マニュアルの閲覧権限もしくは編集権限がありません');
            }
        }

        $manual = Manual::updateOrCreate(
            ['id' => $request->id],
            $inputs
        );

        return redirect('/manual/')->with('flash.success','マニュアルを更新しました');
    }

    public function favorite(Request $request)
    {
        $id   = $request->val;
        $cont = $request->cont;

        if($id) {
            $favorite = Favorite::where('id', $id)->delete();
        } else {
            $favorite = Favorite::updateOrCreate(
                ['id' => $id],
                [
                    'contents_id' => $cont,
                    'register_id' => Auth::user()->id,
                    'type'        => 'M'
                ]
            );
        }

        return response()->json($favorite);
    }

    protected function check(Request $request)
    {
        $credentials = $request->validate(Manual::RULES);

        return null;
    }
}
