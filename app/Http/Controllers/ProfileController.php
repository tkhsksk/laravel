<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Shift;
use App\Models\Manual;
use App\Models\Faq;
use App\Models\Favorite;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use DB;
use App\Models\Models\Location;

class ProfileController extends Controller
{
   public function __construct()
   {
      // 未ログインはsigninにリダイレクト
      $this->middleware('auth');

      $this->disk = Storage::disk('public');
   }

   public function index(Request $request)
   {
      $keyword       = $request->input('note');
      $user_id       = Auth::user()->id;
      $admin         = Admin::getAdmin($user_id);
      $department_id = '';
      $department    = '';
      $location      = '';

      $notes = Note::query()
                  ->where('register_id', '=', $user_id)
                  ->orderBy('created_at', 'desc');

      searchFromTo($notes, 'created_at', $request->input('created_at_st'), $request->input('created_at_en'));

      if(!empty($keyword)) {
         $spaceConversion = mb_convert_kana($keyword, 's');
         $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

         foreach($wordArraySearched as $value) {
             $notes
             ->where('title', 'LIKE', "%{$value}%");
         }
         $keyword = implode(' ', $wordArraySearched);
      }

      $shifts    = Shift::query()
                     ->where('register_id', '=', $user_id)
                     ->orderBy('preferred_date', 'desc')
                     ->paginate(18);
      $favorites = Favorite::query()
                     ->where('register_id', '=', $user_id)
                     ->where('type', '=', 'M')
                     ->orderBy('updated_at', 'desc')
                     ->paginate(18);

      if($admin){
         $department_id = DB::table('user_admins')
            ->where('user_id',$user_id)
            ->first()
            ->department_id;

         $department = '';
         $location   = '';

         $department = DB::table('departments')->find($department_id);
         if($department){
            $location = DB::table('location')->find($department->location_id);
         }
      }

      return view('profile.index', [
         'user'       => Auth::user(),
         'corp'       => $location,
         'age'        => getAgefromBirthday(Auth::user()->birthday),
         'admin'      => $admin,
         'timer'      => \Carbon\Carbon::now()->format('H'),
         'shifts'     => $shifts,
         'favorites'  => $favorites,
         'notes'      => $notes->paginate(20),
         'keyword'    => $keyword,
         'request'    => $request,
      ]);
   }

   public function edit()
   {  
      $user = User::find(Auth::user()->id);

      return view('profile.edit', [
         'user' => Auth::user(),
      ]);
   }

   public function confirm(Request $request)
   {
      $this->check($request);

      $profile     = $request->input();
      $image_input = $request->file('image');

      if ($image_input) {
         // 画像の入力があった場合
         $imageExtension = $image_input->getClientOriginalExtension(); // 画像拡張子
         $fileName       = uniqid() . "." . $imageExtension; // 一時画像のファイル名

         $this->disk->putFileAs('/user/'.Auth::user()->id.'/temp', $image_input, $fileName);
         $path = '/public/user/'.Auth::user()->id.'/temp/'.$fileName;
      } else {
         $imageExtension = '';
         $fileName       = '';
         $path           = '';
      }

      return view('profile.confirm', [
         'user'       => Auth::user(),
         'imageInput' => $image_input,
         'imageName'  => $fileName,
         'imagePath'  => $path,
         'profile'    => $profile,
         'extension'  => $imageExtension,
      ]);
   }

   public function store(Request $request)
   {
      $disk = Storage::disk('public');

      $user           = User::user();
      $user_id        = Auth::user()->id;

      $imageExtension = $request->extension;
      $imagePath      = $request->image;
      $imageName      = $request->image_name;
      $imageReset     = $request->reset_image;

      $request->request->remove('image');
      $request->request->remove('image_name');
      $request->request->remove('reset_image');

      $this->check($request);

      $request->merge([
         'adobe_pass' => encrypt($request->adobe_pass),
         'image'      => $imagePath
      ]);

      $request->request->remove('extension');

      if($imageExtension) {
         $disk->move('/user/'.$user_id.'/temp/'.$imageName, '/user/'.$user_id.'/'.$imageName);
         if($request->image) {
            $request->merge(['image' => '/public/user/'.$user_id.'/'.$imageName]);
         }
      } else {
         if(User::find($user_id)->image && !$imageReset) {
            $request->merge(['image' => User::find($user_id)->image]);
         }
      }

      User::updateOrCreate(
         ['id' => $user_id],
         $request->all()
      );

      // 一時フォルダの削除
      $disk->deleteDirectory('/user/'.Auth::user()->id.'/temp');

      return redirect('/profile')->with('flash.success','プロフィールを更新しました');
   }

   public function easy(Request $request)
   {
      if(!$request->id || $request->id != Auth::user()->id){
         return redirect('/profile')->with('flash.failed','入力値が異常です');
      }

      $request->validate([
         'name'      => ['required', 'max:50'],
         'birthday'  => ['required'],
         'image'     => ['nullable', 'max:500', 'mimes:jpg,jpeg,png']
      ]);

      $image_input = $request->file('image');
      $fileName    = null;
      $path        = User::find(Auth::user()->id)->image;

      if ($image_input) {
         // 画像の入力があった場合
         $imageExtension = $image_input->getClientOriginalExtension(); // 画像拡張子
         $fileName       = uniqid() . "." . $imageExtension; // 一時画像のファイル名
         $path = '/public/user/'.Auth::user()->id.'/'.$fileName;

         $this->disk->putFileAs('/user/'.Auth::user()->id, $image_input, $fileName);
      }
      elseif ($request->reset_image) {
         $path = null;
      }

      $params = [
         'id'       => $request->id,
         'name'     => $request->name,
         'birthday' => $request->birthday,
         'image'    => $path
      ];
 
      User::where('id', $request->id)->update($params);

      return redirect('/profile')->with('flash.success','かんたんプロフィールを登録しました');
   }

   public function note(Request $request)
   {
      $request->session()->flash('_old_input',['id' => $request->id,'note' => $request->note]);

      $this->checkNote($request);

      if(Auth::user()->id != $request->register_id) {
         return redirect('/profile')->with('flash.failed','id変えちゃだめ');
      }

      $request->session()->flash('_old_input',['id' => '','note' => '']);
      $note   = new Note();
      $inputs = $request->all();

      $note = Note::updateOrCreate(
          ['id' => $request->id],
          $inputs
      );

      return redirect('/profile')->with('flash.success','メモを保存しました');
   }

   public function getNote(Request $request)
   {
      $jsons = [];
      $id    = $request->val;
      $datas = Note::find($id);

      if(Auth::user()->id == $datas->register_id){
         return response()->json($datas);
      }
   }

   protected function check($request)
   {
      $credentials = $request->validate(User::setValidateForUser());

      return null;
   }

   protected function checkNote($request)
   {
      $credentials = $request->validate(Note::RULES);

      return null;
   }
}
