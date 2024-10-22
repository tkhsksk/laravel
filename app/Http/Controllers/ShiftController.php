<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ShiftRequest;
use App\Models\Shift;
use App\Models\Admin;
use App\Models\Config;

class ShiftController extends Controller
{
    public function __construct()
    {
        // 未ログインはsigninにリダイレクト
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $shifts = Shift::query();

        $conditions = [
            'status'      => $status      = $request->input('status'),
            'register_id' => $register_id = $request->input('register_id'),
            'charger_id'  => $charger_id  = $request->input('charger_id'),
            'holiday'     => $holiday     = $request->input('holiday'),
        ];

        searchFromTo($shifts, 'preferred_date', $request->input('preferred_date_st'), $request->input('preferred_date_en'));
        searchFromTo($shifts, 'created_at', $request->input('created_at_st'),     $request->input('created_at_en'));

        foreach($conditions as $col => $val) {
            if(!empty($val)){
                $shifts
                ->where($col, '=', $val);
            }
        }

        return view('shift.index', [
            'admins'  => getStatusEnable(new Admin),
            'shifts'  => $shifts->orderBy('created_at', 'desc')->paginate(10),
            'request' => $request,
        ]);
    }

    public function calendar(Request $request)
    {
        $year       = $request->input('year') ?? Carbon::today()->format('Y');
        $month      = $request->input('month') ?? Carbon::today()->format('m');
        $calendarYm = Carbon::Create($year, $month, 01, 00, 00, 00);
        $weekNames  = ['日', '月', '火', '水', '木', '金', '土'];
        $depart     = $request->input('depart') ?? $request->input('depart');
        $myself     = $request->input('myself') ?? $request->input('myself');

        // 新規追加の場合
        if($request->input('depart')) {
            Cookie::queue('default_shift_depart', $depart, 1209600);// 二週間保存
        } else {
            Cookie::queue(Cookie::forget('default_shift_depart'));
        }
        $admins = Admin::query()->where('department_id', '=', $depart)->get();

        $admin_ids = [];
        foreach($admins as $admin){
            $admin_ids[] = $admin->id;
        }

        $holiDays = getHolidays();

        $newHolidays = [];
        $i = 0;
        foreach($holiDays as $date => $holiDay){
            $newHolidays[$i]['date'] = $date;
            $newHolidays[$i]['name'] = $holiDay;
            $i++; 
        }

        $collectedNewHolidays = collect($newHolidays);
        $flippedNewHolidays   = $collectedNewHolidays->pluck('date')->flip()->all();

        $calendarDays = [];

        // 月初の日付が日曜日ではないときの、追加する前月カレンダーの日付。
        if($calendarYm->dayOfWeek != 0){
            $schedules = [];
            $calendarStartDay = $calendarYm->copy()->subDays($calendarYm->dayOfWeek);
            for ($i = 0; $i < $calendarYm->dayOfWeek; $i++) {
                $calendarDays[] = [
                    'date'        => $calendarStartDay->copy()->addDays($i),
                    'show'        => true,
                    'status'      => true,
                    'holidayName' => '',
                    'schedules'   => $schedules,
                ];
            }
        }

        // 当月の日付
        for ($i = 0; $i < $calendarYm->daysInMonth; $i++) {
            $schedules = [];
            if($calendarYm->copy()->addDays($i) >= Carbon::now()){
                $show   = true;
                $status = false;
            } else {
                $show   = true;
                $status = false;
            }

            if (Gate::denies('isMasterOrAdmin')){
                $shifts = Shift::query()
                    ->orderBy('status', 'desc')
                    ->orderByRaw('CONVERT(preferred_hr_st, SIGNED) asc')
                    ->where(
                        function ($query) use($calendarYm, $i) {
                            $query
                            ->where('preferred_date', '=', $calendarYm->copy()->addDays($i))
                            ->where('status', '!=', 'R')// 申請無効
                            ->where('register_id', '=', Auth::user()->id);
                        }
                    )
                    ->orWhere(
                        function ($query) use($calendarYm, $i) {
                            $query
                            ->where('preferred_date', '=', $calendarYm->copy()->addDays($i))
                            ->where('status', '=', 'E')// 承認済
                            ->where('register_id', '!=', Auth::user()->id);
                        }
                    );
            } else {
                $shifts = Shift::query()
                    ->orderBy('status', 'desc')
                    ->orderByRaw('CONVERT(preferred_hr_st, SIGNED) asc')
                    ->where('preferred_date', '=', $calendarYm->copy()->addDays($i))
                    ->where('status', '!=', 'R');// 申請無効
            }

            if($depart){
                if(count($admin_ids) > 0){
                    $shifts = $shifts->whereIn('register_id', $admin_ids);
                } elseif($depart == 'self') {
                    $shifts = $shifts->where('register_id', '=', Auth::user()->id);
                } else {
                    $shifts = Shift::query()->where('id', '=', '');
                }
            }

            $shifts = $shifts->get();

            foreach($shifts as $shift) {
                $schedules[] = $shift;
            }

            $holidayName = '';
            $dateFormat = $year.'-'.sprintf('%02d', $month).'-'.sprintf('%02d', $i+1);
            if(isset($flippedNewHolidays[$dateFormat])){
                $holidayName = $holiDays[$dateFormat];
            }

            $calendarDays[] = [
                'date'        => $calendarYm->copy()->addDays($i),
                'show'        => $show,
                'status'      => $status,
                'schedules'   => $schedules,
                'holidayName' => $holidayName
            ];
        }

        // 月末の日付が土曜日ではないときの、追加する翌月カレンダーの日付。
        if($calendarYm->copy()->endOfMonth()->dayOfWeek != 6){
            $schedules = [];
            $restDays  = abs($calendarYm->copy()->endOfMonth()->dayOfWeek - 6);
            for ($i = $calendarYm->copy()->endOfMonth()->dayOfWeek+($restDays - 6); $i < $restDays; $i++) {
                $calendarDays[] = [
                    'date'        => $calendarYm->copy()->addDays($i),
                    'show'        => true,
                    'status'      => true,
                    'holidayName' => '',
                    'schedules'   => $schedules,
                ];
            }
        }

        return view('shift.calendar', [
            'calendarDays'  => $calendarDays,// 集めた日付
            'previousMonth' => $calendarYm->copy()->subMonth(),// 前月
            'nextMonth'     => $calendarYm->copy()->addMonth(),// 翌月
            'thisMonth'     => $calendarYm,// 当月
            'weekNames'     => $weekNames,
            'requests'      => $request,
        ]);
    }

    public function getshiftdata(Request $request)
    {
        $jsons  = [];
        $date   = $request->val;
        $depart = $request->dep??$request->dep;
        $admins = Admin::query()
                        ->where('department_id', '=', $depart)
                        ->get();

        $admin_ids = [];
        foreach($admins as $admin){
            $admin_ids[] = $admin->id;
        }

        if (Gate::denies('isMasterOrAdmin')){
            $datas = Shift::query()
                    ->orderBy('status', 'desc')
                    ->orderByRaw('CONVERT(preferred_hr_st, SIGNED) asc')
                    ->where(
                        function ($query) use ($date) {
                            $query
                            ->where('preferred_date', '=', $date)
                            ->where('status', '!=', 'R')
                            ->where('register_id', '=', Auth::user()->id);
                        }
                    )
                    ->orWhere(
                        function ($query) use ($date) {
                            $query
                            ->where('preferred_date', '=', $date)
                            ->where('status', '=', 'E')
                            ->where('register_id', '!=', Auth::user()->id);
                        }
                    );
        } else {
            $datas = Shift::query()
                    ->orderBy('status', 'desc')
                    ->orderByRaw('CONVERT(preferred_hr_st, SIGNED) asc')
                    ->where('preferred_date', '=', $date)
                    ->where('status', '!=', 'R');
        }

        if($depart){
            if(count($admin_ids) > 0){
                $datas = $datas->whereIn('register_id', $admin_ids);
            } elseif($depart == 'self') {
                $datas = $datas->where('register_id', '=', Auth::user()->id);
            } else {
                $datas = Shift::query()->where('id', '=', '');
            }
        }

        $datas = $datas->get();

        foreach($datas as $in => $data) {
            $jsons[$in]['image'] = getUserImage($data['register_id']);
            $jsons[$in]['name']  = getNamefromUserId($data['register_id'],'F');
            $jsons[$in]['href']  = '/shift/detail/'.$data['id'];
            $jsons[$in]['time']  = $data['preferred_hr_st'].':'.sprintf('%02d', $data['preferred_min_st']).'〜'.$data['preferred_hr_end'].':'.sprintf('%02d', $data['preferred_min_end']);
            if($data['status'] == 'N') {
                $jsons[$in]['color'] = 'primary';
            } elseif ($data['status'] == 'E') {
                $jsons[$in]['color'] = 'success-new';
            } else {
                $jsons[$in]['color'] = 'dark';
            }
            $jsons[$in]['note'] = '';
            if(!empty($data['note'])) {
                $jsons[$in]['note'] = '<div class="text-center me-md-1"><i class="ph ph-chat-text fs-7"></i><p class="mb-0 small lh-1">連絡事項あり</p></div>';
            }
            $jsons[$in]['holiday'] = '';
            if($data['holiday'] == 'E') {
                $jsons[$in]['holiday'] = '<i class="ph ph-island me-2 text-dark"></i>';
            }
        }

        return response()->json($jsons);
    }

    public function detail(Request $request, $id = '')
    {
        $shift = new Shift;
        $shift = Shift::find($id);
        $login_id = Auth::user()->id;

        if($shift->status === 'N'){
            // isMasterOrAdminはallow
            if (Gate::denies('isMasterOrAdmin', Auth::user()) && $shift->register_id != $login_id) {
                // 弾いたやつは以下処理
                // isMasterOrAdminじゃなくても、isShiftUpdatebleはallow
                if (Gate::denies('isShiftUpdateble', $shift)) {
                    // 弾いたやつは以下処理
                    return redirect('/shift')->with('flash.failed','他のユーザーの新規申請シフトは閲覧できません');
                }
            }
        }

        return view('shift.detail', [
            'shift' => $shift,
        ]);
    }

    public function edit(Request $request, $id = '')
    {
        $shift          = new Shift;
        $shift          = Shift::find($id);
        $statuses       = Shift::STATUS;
        $preferred_date = $request->input('preferred_date') ? $request->input('preferred_date') : false;

        if($shift){
            if($shift->status === 'N'){
                if (Gate::denies('isShiftUpdateble', $shift)) {
                    return redirect('/shift')->with('flash.failed','登録者もしくは承認者のみシフトを編集できます');
                }

                if($shift->register_id === Auth::user()->id){
                    // 登録者が既存シフトを編集する場合、自身が登録した新規申請シフトのみ選択可能
                    unset($statuses['E']);
                    // unset($statuses['R']);
                }
            } else {
                if ($shift->charger_id != Auth::user()->id) {
                    if (Gate::denies('isMasterOrAdmin')){
                        return redirect('/shift')->with('flash.failed','新規申請以外のシフトは承認者以外編集できません');
                    }
                }
            }
        }

        return view('shift.edit', [
            'shift'          => $shift,
            'hours'          => range(9, 18, 1),
            'mins'           => range(00, 45, 15),
            'admins'         => getStatusEnable(new Admin),
            'statuses'       => $statuses,
            'preferred_date' => $preferred_date
        ]);
    }

    public function confirm(ShiftRequest $request)
    {
        $login_id = Auth::user()->id;
        $shift    = new Shift;
        $shift    = Shift::find($request->id);

        if($shift){
            if($request->register_id != $login_id && $shift->charger_id != $login_id){
                // 登録者がログインユーザーと一致してなくて、シフトの現承認者とも一致してない
                if (Gate::denies('isMasterOrAdmin')){
                    // 管理者以上はOK
                    return back()->with('flash.failed','登録者のidが一致していません');
                }
            }
        }

        // 新規追加の場合
        if(!$request->id) {
            Cookie::queue(Cookie::forget('default_charger'));
            Cookie::queue('default_charger', $request->charger_id,  1209600);// 二週間保存
        }

        $inputs = $request->all();

        return view('shift.confirm', [
            'inputs' => $inputs,
        ]);
    }

    public function editAdmin(Request $request, $id = '')
    {
        $shift          = new Shift;
        $shift          = Shift::find($id);
        $statuses       = Shift::STATUS;
        $preferred_date = $request->input('preferred_date') ? $request->input('preferred_date') : false;

        if($shift){
            if($shift->status === 'N'){
                if (Gate::denies('isShiftUpdateble', $shift)) {
                    return redirect('/shift')->with('flash.failed','登録者もしくは承認者のみシフトを編集できます');
                }

                if($shift->register_id === Auth::user()->id){
                    // 登録者が既存シフトを編集する場合、自身が登録した新規申請シフトのみ選択可能
                    unset($statuses['E']);
                    unset($statuses['R']);
                }
            } else {
                if ($shift->charger_id != Auth::user()->id) {
                    if (Gate::denies('isMasterOrAdmin')){
                        return redirect('/shift')->with('flash.failed','新規申請以外のシフトは承認者以外編集できません');
                    }
                }
            }
        }

        return view('shift.admin.edit', [
            'shift'          => $shift,
            'hours'          => range(9, 18, 1),
            'mins'           => range(00, 45, 15),
            'admins'         => getStatusEnable(new Admin),
            'statuses'       => $statuses,
            'preferred_date' => $preferred_date
        ]);
    }

    public function approval($id = '')
    {
        $login_id = Auth::user()->id;
        $shift    = new Shift;
        $shift    = Shift::find($id);

        if($shift->charger_id != $login_id){
            // 登録者がログインユーザーと一致してなくて、シフトの現承認者とも一致してない
            return back()->with('flash.failed','あなたは承認者ではありません');
        } else {
            $shift->status = 'E';
            $shift->save();
            return redirect('/shift')->with('flash.success','シフトのリクエストを承認しました');
        }

        return view('shift.approval', [
        ]);
    }

    public function store(ShiftRequest $request, $id = '')
    {
        $shift  = new Shift();
        $inputs = $request->all();

        $shift = Shift::updateOrCreate(
            ['id' => $request->id],
            $inputs
        );

        $param = '?depart='.$request->cookie("default_shift_depart").'&year='.substr($request->preferred_date, 0, 4).'&month='.substr($request->preferred_date, 5, 2);

        return redirect('/shift/calendar'.$param)->with('flash.success','シフトを提出しました');
    }

    public function total(Request $request)
    {
        $requestRegisters = [];
        $requestRegisters = $request->register_id;

        $totals = [];
        $totalCollection = [];
        $days_arr = [];

        if($requestRegisters && $request->month){
            foreach($requestRegisters as $requestRegister){
                $shifts = Shift::getTotalShifts($requestRegister, substr($request->month, 0, 4), substr($request->month, 5, 2))->get();
                $shift_ids = [];
                foreach($shifts as $shift){
                    $shift_ids[] = $shift->id;
                }
                $totals[$requestRegister]['user_id'] = $requestRegister;
                $totals[$requestRegister]['days']    = count($shifts);
                $totals[$requestRegister]['secs']    = Shift::getTotalShiftsTimes($shift_ids);
            }
        }

        $totalCollection = collect($totals);

        if($request->status && $request->status != 0) {
            $totalCollection = $totalCollection->sortByDesc(Shift::SORT[$request->status][1]);
        }

        return view('shift.total', [
            'admins'   => getStatusEnable(new Admin),
            'request'  => $request,
            'registers'=> $requestRegisters,
            'totals'   => $totalCollection,
        ]);
    }
}
