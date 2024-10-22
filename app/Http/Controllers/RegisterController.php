<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Rules\RuleEmail;
use App\Mail\EntryMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
   public function index($guard = null)
   {
      if (Auth::guard($guard)->check()) {
         return redirect()->route('home');
      }

      return view('register.index');
   }

   public function register(Request $request)
   {
      $request->session()->flash('_old_input',[
         'name'  => $request['name'],
         'email' => $request['email'],
      ]);

      $request->validate([
         'name'     => ['required','max:50'],
         'email'    => ['required','unique:users,email',new RuleEmail],// emailは必須且つユニークであること
         'password' => ['required','max:128',Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
      ]);

      $user = User::query()->create([
         'name'     => $request['name'],
         'email'    => $request['email'],
         'password' => Hash::make($request['password'])
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

      return redirect()->route('login')->with('flash.success','アカウント登録が完了しました<br />そのままサインインが可能です');
   }
}
