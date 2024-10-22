<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Equipment;
use App\Models\Employment;
use App\Models\Department;
use App\Models\Files;
use App\Rules\RuleEmail;
use App\Mail\EntryMail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DB;

class AdminController extends Controller
{
    public function __construct()
    {
        // 未ログインはsigninにリダイレクト
        $this->middleware('auth');

        $this->disk = Storage::disk('protected');
    }

    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $status  = $request->input('status');

        if(!empty($status)) {
            $admins = Admin::query();// 初期ページでは有効な社員のみ
        } else {
            $admins = Admin::query()->where('status','E');// 初期ページでは有効な社員のみ
        }

        if(!empty($request->input())) {
            $admins->leftJoin('users', 'user_admins.user_id', '=', 'users.id');
        }

        if(!empty($keyword)) {
            $spaceConversion = mb_convert_kana($keyword, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            foreach($wordArraySearched as $value) {
                $admins
                ->where(DB::raw('CONCAT(first_name, second_name)'), 'LIKE', "%{$value}%")
                ->orWhere(DB::raw('CONCAT(first_kana, second_kana)'), 'LIKE', "%{$value}%")
                ->orWhere(DB::raw('email'), 'LIKE', "%{$value}%");
            }
            $keyword = implode(' ', $wordArraySearched);
        }

        return view('admin.index', [
            'locations'   => 'App\Models\Location'::all(),
            'employments' => Employment::all(),
            'keyword'     => $keyword,
            'status'      => $status,
            'admins'      => $admins->orderBy('user_admins.created_at', 'desc')->paginate(12),
        ]);
    }

    public function add(Request $request)
    {
        $user = new User();

        $request->validate([
            'name'     => ['required','max:50'],
            'email'    => ['required','unique:users,email',new RuleEmail],// emailは必須且つユニークであること
        ]);

        $user = $user->create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Str::password(12),
            'created_at' => now(),
        ]);

        // とりあえずadmin作っとく
        Admin::updateOrCreate(
            ['id'      => $user->id],
            ['user_id' => $user->id]
        );

        // 会員登録完了のメール;
        $mail = new EntryMail($request);
        $recipients = Admin::query()
                        ->where('status','E')
                        ->where('role','M')
                        ->get();

        $cc = [];
        foreach($recipients as $recipient)
        {
           $cc[] = $recipient->user->email;
        }

        // 本人に送信、マスター権限にcc
        Mail::to($request['email'])->cc($cc)->send($mail);

        return redirect('/admin')->with('flash.success','新規ユーザーを追加しました');
    }

    public function detail(Request $request, $id = '')
    {
        // まだAdminモデルが存在しないが、空っぽのAdminモデルを作成したい時
        $admin = new Admin;
        $equipments = Equipment::where('admin_id', $id)->get();
        // 対象ユーザーのファイル一覧
        $images = Files::query()
                  ->where('admin_id',$id)
                  ->where('status','E')
                  ->Where(function($query){
                    $query
                    ->where('extension','png')
                    ->orWhere('extension','jpg')
                    ->orWhere('extension','jpeg');
                  })
                  ->orderBy('updated_at', 'desc');

        $files  = Files::query()
                  ->where('admin_id',$id)
                  ->where('status','E')
                  ->Where(function($query){
                    $query
                    ->where('extension','pdf')
                    ->orWhere('extension','ai')
                    ->orWhere('extension','psd');
                  })
                  ->orderBy('updated_at', 'desc');

        if(Admin::where('user_id', $id)->first()){
            $admin = Admin::where('user_id', $id)->first();
        }

        $user = User::find($id);

        return view('user.detail.index', [
            'admin'        => $admin,
            'equipments'   => $equipments,
            'user'         => $user,
            'admin_status' => Admin::ADMIN_STATUS,
            'admin_roles'  => Admin::ADMIN_ROLES,
            'images'       => $images->paginate(20, ['*'], 'imagesPage'),
            'files'        => $files->paginate(10, ['*'], 'filesPage'),
        ]);
    }

    public function edit(Request $request, $id = '')
    {
        // まだAdminモデルが存在しないが、空っぽのAdminモデルを作成したい時
        $admin           = new Admin;
        $equipments      = Equipment::where('admin_id', $id)->get();
        $equipments_null = Equipment::select('*')->whereNull('admin_id')->get();
        $equipments_able = $equipments->merge($equipments_null);
        // 対象ユーザーのファイル一覧
        $images = Files::query()
                  ->where('admin_id',$id)
                  ->where('status','E')
                  ->Where(function($query){
                    $query
                    ->where('extension','png')
                    ->orWhere('extension','jpg')
                    ->orWhere('extension','jpeg');
                  })
                  ->orderBy('updated_at', 'desc');

        $files  = Files::query()
                  ->where('admin_id',$id)
                  ->where('status','E')
                  ->Where(function($query){
                    $query
                    ->where('extension','pdf')
                    ->orWhere('extension','ai')
                    ->orWhere('extension','psd');
                  })
                  ->orderBy('updated_at', 'desc');

        if(Admin::where('user_id', $id)->first()){
            $admin = Admin::where('user_id', $id)->first();
        }

        $user = User::find($id);

        return view('user.edit.index', [
            'admin'           => $admin,
            'user'            => $user,
            'admin_status'    => Admin::ADMIN_STATUS,
            'admin_roles'     => Admin::ADMIN_ROLES,
            'able_equipments' => $equipments_able,
            'images'          => $images->paginate(20, ['*'], 'imagesPage'),
            'employments'     => getStatusEnable(new Employment),
            'files'           => $files->paginate(10, ['*'], 'filesPage'),
        ]);
    }

    public function confirm(Request $request, $id = '')
    {
        $this->check($request, $request->tab);

        $inputs = $request->all();
        $user = User::find($id);

        return view('user.confirm', [
            'user'   => $user,
            'inputs' => $inputs,
            'tab'    => $request->tab,
        ]);
    }

    public function store(Request $request)
    {
        $this->check($request, $request->tab);

        switch ($request->tab) {
            case 'admin':
                $columns = [
                    'code'          => $request->code,
                    'user_id'       => $request->user_id,
                    'employment_id' => $request->employment_id,
                    'status'        => $request->status,
                    'role'          => $request->role,
                    'engineer_role' => $request->engineer_role,
                    'note'          => $request->note,
                    'department_id' => $request->department_id,
                    'title'         => $request->title,
                    'employed_at'   => $request->employed_at,
                    'started_at'    => $request->started_at,
                ];
                break;
            case 'other':
                $columns = [
                    'filing_status'               => $request->filing_status,
                    'insurance_social_status'     => $request->insurance_social_status,
                    'insurance_employment_status' => $request->insurance_employment_status,
                    'insurance_employment_number' => $request->insurance_employment_number,
                ];
                break;
            case 'account':
                $columns = [
                    'user_id'             => $request->user_id,
                    'mm_name'             => $request->mm_name,
                    'mm_pass'             => encrypt($request->mm_pass),
                    'google_account'      => $request->google_account,
                    'google_account_pass' => encrypt($request->google_account_pass),
                    'win_device_name'     => $request->win_device_name,
                    'ms_account'          => $request->ms_account,
                    'ms_account_password' => encrypt($request->ms_account_password),
                    'apple_id'            => $request->apple_id,
                    'apple_pass'          => encrypt($request->apple_pass),
                    'mac_name'            => $request->mac_name,
                    'mac_account_name'    => $request->mac_account_name,
                    'mac_account_pass'    => encrypt($request->mac_account_pass),
                    'pin'                 => $request->pin,
                ];
                break;
            default :
                break;
        }

        Admin::updateOrCreate(
            ['id' => $request->user_id],
            $columns
        );

        return redirect('/user/detail/'.$request->user_id)->with('flash.success','プロフィールを更新しました');
    }

    protected function ajax(Request $request)
    {
        $id = $request->val;
        $departments = Department::where('location_id', $id)->get();
        return response()->json($departments);
    }

    protected function equipment(Request $request)
    {
        $ids = $request->equipment;
        $equipments = [];

        Admin::updateOrCreate(
            ['id'      => $request->user],
            ['user_id' => $request->user],
        );

        Equipment::where('admin_id', $request->user)
                ->update([
                    'admin_id' => null,
                    'status'   => 'N',
                ]);

        if($ids)// 入力値があれば
            foreach($ids as $id){
                Equipment::where('id', $id)
                    ->update([
                        'admin_id' => $request->user,
                        'status'   => 'U',
                    ]);
                $equipments[] = Equipment::find($id);
            }

        return response()->json($equipments);
    }

    public function media(Request $request)
    {
        $request->validate([
            'files'   => 'required',
            'files.*' => 'required|mimes:png,jpg,jpeg|max:1024',
        ]);

        $files = [];
        if ($request->file('files')){
            foreach($request->file('files') as $key => $file)
            {
                $fileName = time().Str::random(10).'.'.$file->getClientOriginalExtension();
                $files[$key]['size']        = $file->getSize();// getsizeはputFileAsの前に行う必要がある

                $path                       = $this->disk->putFileAs('admin/'.$request->admin_id, $file, $fileName);
                $files[$key]['url']         = '/protected/admin/'.$request->admin_id.'/'.$fileName;

                $files[$key]['register_id'] = Auth::user()->id;
                $files[$key]['name']        = $fileName;
                $files[$key]['origin_name'] = $file->getClientOriginalName();
                $files[$key]['admin_id']    = $request->admin_id;
                $files[$key]['extension']   = $file->getClientOriginalExtension();
            }
        }
    
        foreach ($files as $key => $file) {
            Files::create($file);
        }
       
        return back()
                ->with('flash.success','メディアを登録しました');
    }

    public function file(Request $request)
    {
        $request->validate([
            'files'   => 'required',
            'files.*' => 'required|mimes:pdf,ai,psd|max:10240',
        ]);

        $files = [];
        if ($request->file('files')){
            foreach($request->file('files') as $key => $file)
            {
                $fileName = time().Str::random(10).'.'.$file->getClientOriginalExtension();
                $files[$key]['size']        = $file->getSize();// getsizeはputFileAsの前に行う必要がある

                $path                       = $this->disk->putFileAs('admin/'.$request->admin_id, $file, $fileName);
                $files[$key]['url']         = '/protected/admin/'.$request->admin_id.'/'.$fileName;

                $files[$key]['register_id'] = Auth::user()->id;
                $files[$key]['name']        = $fileName;
                $files[$key]['origin_name'] = $file->getClientOriginalName();
                $files[$key]['admin_id']    = $request->admin_id;
                $files[$key]['extension']   = $file->getClientOriginalExtension();
            }
        }
    
        foreach ($files as $key => $file) {
            Files::create($file);
        }
       
        return back()
                ->with('flash.success','ファイルを登録しました');
    }

    protected function check(Request $request, $tab)
    {
        switch ($tab) {
            case 'admin':
                $credentials = $request->validate(Admin::RULES_ADMIN);
                break;
            case 'other':
                $credentials = $request->validate(Admin::RULES_OTHER);
                break;
            case 'account':
                $credentials = $request->validate(Admin::RULES_ACCOUNT);
                break;
            default :
                break;
        }

        return null;
    }
}
