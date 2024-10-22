<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Mail\PasswordMail;
use App\Models\User;

class PasswordController extends Controller
{
    public function index($guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect()->route('home');
        }

        return view('password.index');
    }

    public function send(Request $request)
    {
        $urls = [
            'reset' => URL::temporarySignedRoute(
                'password.reset',
                now()->addMinutes(10),  // 10分間だけ有効
                [
                    'from'  => $request->name,
                    'email' => $request->email,
                ]
            ),
            'bye' => URL::temporarySignedRoute(
                'hello.bye',
                now()->addMinutes(10),  // 10分間だけ有効
                [
                    'from'  => $request->name,
                    'email' => $request->email,
                ]
            ),
        ];

        $request->session()->flash('_old_input',[
            'email' => $request['email'],
        ]);

        $credentials = $request->validate([
            'email' => 'required|email:filter|exists:users,email',
        ]);

        // $user = User::where('email',$request['email'])->first();
        // $user->email_verified_at = now();
        // $user->save();

        $mail = new PasswordMail($request, $urls);
        Mail::to($request['email'])->send($mail);

        return redirect()->route('password.sent');
    }

    public function sent($guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect()->route('home');
        }

        return view('password.sent');
    }

    public function reset(Request $request)
    {
        // リンクの検証
        if (!$request->hasValidSignature()) {
            return redirect()->route('password.invalid');
        }

        $password = '';
        if($email = $request->input('email')){
            $password = Str::password();
            $user = User::where('email',$email)->first();
            $user->password = Hash::make($password);
            $user->save();
        }

        return view('password.reset', [
            'password' => $password,
        ]);
    }

    public function change(Request $request)
    {
        $request->validate([
            'email'    => 'required|email:filter|exists:users,email',
            //'password' => ['required','max:128',Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ]);

        //$user = User::where('email',$request['email'])->first();
        //$user->password = Hash::make($request['password']);
        //$user->save();

        // $mail = new TestMail($request, $urls);
        // Mail::to($request['email'])->send($mail);

        return redirect('/signin')->with('flash.success','パスワードを更新しました<br />そのままサインインが可能です');
    }

    public function bye(Request $request)
    {
        // リンクの検証
        if (!$request->hasValidSignature()) {
            return redirect()->route('password.invalid');
        }
        return 'bye';
    }

    public function invalid($guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect()->route('home');
        }

        return view('password.invalid');
    }
}
