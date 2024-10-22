<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;
use App\Models\Admin;
use App\Models\Notification;
use App\Http\Requests\NoticeRequest;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function __construct()
    {
        // 未ログインはsigninにリダイレクト
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $notifications = Notification::query()->orderBy('updated_at', 'desc');
        $keyword = $request->input('keyword');

        $conditions = [
            'register_id' => $register_id = $request->input('register_id')
        ];

        if(!empty($keyword)) {
            $spaceConversion = mb_convert_kana($keyword, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) {
                $notifications
                ->where('title', 'LIKE', "%{$value}%");
            }
            $keyword = implode(' ', $wordArraySearched);
        }

        foreach($conditions as $col => $val) {
            if(!empty($val)){
                $notifications
                ->where($col, '=', $val);
            }
        }


        return view('notification.index', [
            'notifications'   => $notifications->paginate(10),
            'keyword'         => $keyword,
            'admins'          => getStatusEnable(new Admin),
            'register_id_req' => $register_id,
        ]);
    }

    public function list()
    {
        $roles = getArrToRole(array_reverse(Admin::ADMIN_ROLES), Auth::user()->admin->role);

        $notifications = Notification::getQuery()
                            ->whereIn('role', $roles)
                            ->orderBy('created_at', 'desc');

        return view('notification.list', [
            'notifications' => $notifications->paginate(20),
        ]);
    }

    public function detail(Request $request, $id = '')
    {
        $notice  = new Notification;
        $notice  = Notification::find($id);
        $timeRow = Notification::getTimer($notice);

        $roles = getArrToRole(array_reverse(Admin::ADMIN_ROLES), $notice->role);

        if($notice->register_id != Auth::user()->id) { //登録者以外
            if (Gate::denies('isntNoticeVisible', $notice)) {
                return back()->with('flash.failed','お知らせは非公開です');
            }

            //時間制限
            $now = new Carbon('now');

            if($timeRow) {
                if($timeRow['start']) {
                    $start = new Carbon($timeRow['start']);
                    if($now->lt($start)) {
                        return back()->with('flash.failed','お知らせは非公開です');
                    }
                }
                if($timeRow['end']) {
                    $end = new Carbon($timeRow['end']);
                    if($now->gt($end)) {
                        return back()->with('flash.failed','お知らせは非公開です');
                    }
                }
            }
        }

        $flippedRoles = array_flip($roles);

        return view('notification.detail', [
            'notice' => $notice,
            'timer'  => Notification::getTimer($notice),
            'role'   => !isset($flippedRoles[Auth::user()->admin->role])
        ]);
    }

    public function edit(Request $request, $id = '')
    {
        $notice = new Notification;
        $notice = Notification::find($id);

        if($notice){
            if($notice->register_id != Auth::user()->id) { //登録者以外
                if (Gate::denies('isntNoticeVisible', $notice)) {
                    return back()->with('flash.failed','お知らせは非公開です、非公開のお知らせは登録者のみ編集できます');
                }
            }
        }

        return view('notification.edit', [
            'notice' => $notice,
            'admins' => Admin::all(),
            'hours'  => range(9, 18, 1),
            'mins'   => range(00, 45, 15),
        ]);
    }

    public function confirm(NoticeRequest $request)
    {

        $inputs = $request->all();

        return view('notification.confirm', [
            'inputs' => $inputs,
        ]);
    }

    public function store(NoticeRequest $request, $id = '')
    {
        $notice = new Notification();
        $inputs = $request->all();

        $notice = Notification::updateOrCreate(
            ['id' => $request->id],
            $inputs
        );

        return redirect('/notification/')->with('flash.success','お知らせを更新しました');
    }
}
