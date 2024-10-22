<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Shift;
use App\Models\Admin;
use App\Models\Department;
use Carbon\Carbon;

class TopController extends Controller
{
   public function __construct()
   {
      // 未ログインはsigninにリダイレクト
      $this->middleware('auth');
   }

   public function index(Request $request)
   {
      $shift  = $request->input('shift');
      $depart = Cookie::get('default_shift_depart') ?? Cookie::get('default_shift_depart');

      $roles = getArrToRole(array_reverse(Admin::ADMIN_ROLES), Auth::user()->admin->role);
      $today = new Carbon('today');

      $admins = Admin::query()->where('department_id', '=', $depart)->get();
      $admin_ids = [];
      foreach($admins as $admin){
         $admin_ids[] = $admin->id;
      }

      $notifications = Notification::getQuery()
                        ->whereIn('role', $roles)
                        ->orderBy('created_at', 'desc');

      $shifts        = Shift::query()
                        ->where('status', '=', 'E');

      $depart_disp = 'すべての事業部';

      if($depart){
         if(count($admin_ids) > 0){
            $shifts = $shifts->whereIn('register_id', $admin_ids);
            $depart_disp = Department::find($depart)->name;
         } elseif($depart == 'self') {
            $shifts = $shifts->where('register_id', '=', Auth::user()->id);
            $depart_disp = 'あなたのシフトだけ';
         } else {
            $shifts = Shift::query()->where('id', '=', '');
         }
      }

      if($shift){
         $shifts = $shifts->where('preferred_date', '=', $shift);
      } else {
         $shifts = $shifts->where('preferred_date', '=', $today);
      }
      
      return view('top.index', [
         'notifications' => $notifications->paginate(5),
         'shifts'        => $shifts->orderByRaw('CONVERT(preferred_hr_st, SIGNED) asc')->get(),
         'shift'         => $shift,
         'depart_disp'   => $depart_disp,
      ]);
   }

   protected function cookie(Request $request)
   {
      if($request->type == 'theme'){
         $val          = 'dark';// 初期値
         $theme_cookie = Cookie::get($request->type);

         if($theme_cookie)
            if($theme_cookie == 'dark'){
               $val = 'light';
            } else {
               $val = 'dark';
            }
      }

      if($request->type == 'tab'){
         $val = $request->val;
      }

      Cookie::queue(Cookie::forget($request->type));
      Cookie::queue($request->type, $val, 1440);

      return response()->json($val);
   }
}
