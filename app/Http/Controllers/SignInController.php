<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class SignInController extends Controller
{
    public function index($guard = null)
    {
      if (Auth::guard($guard)->check()) {
         return redirect()->route('home');
      }

      return view('signin.index');
    }

   public function signin(Request $request)
   {
      $request->session()->flash('_old_input',[
         'email' => $request['email'],
      ]);

      $credentials = $request->validate([
         'email'    => 'required|email:filter|exists:users,email',
         'password' => 'required',
      ]);

      if (Auth::attempt($credentials)) {
         $request->session()->regenerate();

         $user = User::find(Auth::user()->id);
         // 無効なユーザー
         if(Admin::find(Auth::user()->id)->status === 'D'){
            Auth::logout();
            return redirect()->route('login')->with('flash.failed','無効なユーザーです');
         }
         $user->signedin_at = \Carbon\Carbon::now();
         $user->timestamps = false;// updated_atは更新させない
         $user->save();

         return redirect()->route('home')->with('flash.success','サインインしました');
      } else {
         return back()->with('flash.failed','パスワードが違います');
      }

      return back();
   }

   public function signout()
   {
      Auth::logout();
      session()->flush();

      return redirect()->route('login')->with('flash.success','サインアウトしました');
   }
}
