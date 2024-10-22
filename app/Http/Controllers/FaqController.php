<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Faq;
use Illuminate\Support\Facades\Gate;
use DB;

class FaqController extends Controller
{
    public function __construct()
    {
        // 未ログインはsigninにリダイレクト
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $keyword    = $request->input('keyword');
        $faqs       = Faq::query();
        $conditions = [
            'register_id'   => $register_id = $request->input('register_id'),
            'status'        => $status = $request->input('status'),
            'department_id' => $department_id = $request->input('department_id')
        ];

        if(!empty($keyword)) {
            $spaceConversion = mb_convert_kana($keyword, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) {
                $faqs
                ->where('question', 'LIKE', "%{$value}%");
            }
            $keyword = implode(' ', $wordArraySearched);
        }

        $roles = getArrToRole(array_reverse(Admin::ADMIN_ROLES), Auth::user()->admin->role);
        $faqs  = $faqs
                  ->whereIn('role', $roles);

        foreach($conditions as $col => $val) {
            if(!empty($val)){
                if($col == 'register_id' && $val == Auth::user()->id){
                    $faqs
                    ->where($col, '=', $val);
                } else {
                    if($col == 'status' && $val == 'D'){
                        $faqs
                        ->where($col, '=', $val);
                    } else {
                        $faqs
                        ->where('status', '=', 'E')
                        ->where($col, '=', $val);
                    }
                }
            } else {
                // 一覧表示
                $faqs
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

        return view('faq.index', [
            'keyword'         => $keyword,
            'admins'          => getStatusEnable(new Admin),
            'register_id_req' => $register_id,
            'department_id'   => $department_id,
            'status'          => $status,
            'faqs'            => $faqs->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public function edit(Request $request, $id = '')
    {
        $faq = new Faq;
        $faq = Faq::find($id);

        if($faq) {
            $roles  = getArrToRole(Admin::ADMIN_ROLES, $faq->role);
            $updatable_ids = $faq->updatable_ids.','.$faq->register_id;

            if (Gate::denies('isFaqVisible', $faq)) {
                if (Gate::denies('isFaqUpdateble', $faq)) {
                    return redirect('/faq')->with('flash.failed','FAQの編集権限がありません');
                }
            } else {
                if (Gate::denies('isFaqUpdateble', $faq)) {
                    return redirect('/faq')->with('flash.failed','FAQの編集権限がありません');
                }
            }
        }

        $admins = Admin::query()
                    ->where('status','=','E');

        if($faq) {
            $admins = $admins->where('id','!=',$faq->register_id);
        }

        return view('faq.edit', [
            'faq'    => $faq,
            'admins' => $admins->get(),
        ]);
    }

    public function confirm(Request $request)
    {
        $this->check($request);

        $inputs = $request->all();

        return view('faq.confirm', [
            'inputs' => $inputs,
        ]);
    }

    public function store(Request $request, $id = '')
    {
        $this->check($request);
        $faq    = new Faq();
        $inputs = $request->all();

        if($request->id) {
            $faq    = Faq::find($request->id);
            $roles  = getArrToRole(Admin::ADMIN_ROLES, $faq->role);
            $updatable_ids = $faq->updatable_ids.','.$faq->register_id;

            if (Gate::denies('isFaqUpdateble', $faq)) {
                return back()->with('flash.failed','FAQの編集権限がありません');
            }
        }

        $faq = Faq::updateOrCreate(
            ['id' => $request->id],
            $inputs
        );

        return redirect('/faq/')->with('flash.success','FAQを更新しました');
    }

    // ヘッダー検索用
    public function search(Request $request)
    {
        $word  = $request->word;
        $id    = $request->id;
        $roles = getArrToRole(array_reverse(Admin::ADMIN_ROLES), Auth::user()->admin->role);

        if(!empty($word)) {
            $spaceConversion = mb_convert_kana($word, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) {
                $datas = Faq::query()
                           ->where(DB::raw('CONCAT(question, answer)'), 'LIKE', "%{$value}%")
                           ->where('status', '=', 'E');
            }

            $datas = $datas
                        ->whereIn('role', $roles);
            $datas = $datas->get();
        }

        if(!empty($id)) {
            $datas = Faq::query()
                       ->whereIn('role', $roles)
                       ->find($id);

            if($datas->register_id != Auth::user()->id && $datas->status == 'D'){
                $datas = new Faq;
            }
        }

        return response()->json($datas);
    }

    protected function check(Request $request)
    {
        $credentials = $request->validate(Faq::RULES);

        return null;
    }
}
