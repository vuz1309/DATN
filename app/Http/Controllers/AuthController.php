<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use Mail;
use Str;

class AuthController extends Controller
{
    public function login()
    {

        if (!empty(Auth::check())) {
            return redirect('vAdmin/dashboard');
        }
        return view('auth.login');
    }

    public function AuthLogin(Request $request)
    {

        $remember = !empty($request->remember) ? true : false;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {
            if (Auth::user()->user_type == 1) {
                return redirect('vAdmin/dashboard');
            } else if (Auth::user()->user_type == 2) {
                return redirect('vTeacher/dashboard');
            } else if (Auth::user()->user_type == 3) {
                return redirect('vStudent/dashboard');
            } else if (Auth::user()->user_type == 4) {
                return redirect('vParent/dashboard');
            }
        } else {
            return redirect()->back()->with('error', 'Tài khoản hoặc mật khẩu không chính xác!');
        }
    }

    public function forgotpassword()
    {
        return view('auth.forgot');
    }

    public function PostForgotpassword(Request $request)
    {
        $user = User::getEmailSingle($request->email);
        if (!empty($user)) {

            $user->remember_token = Str::random(30);
            $user->save();
            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return redirect()->back()->with('success', 'Kiểm tra email của bạn và làm mới lại mật khẩu.');
        } else {
            return redirect()->back()->with('error', 'Email chưa được đăng ký tài khoản!');
        }
    }


    public function reset($token)
    {
        $user = User::getTokenSingle($token);
        if (!empty($user)) {
            $data['user'] = $user;
            return view('auth.reset', $data);
        } else {
            abort(404);
        }
    }

    public function PostReset($token, Request $request)
    {
        if ($request->password != $request->confirmPassword) {
            return redirect()->back()->with('error', 'Mật khẩu không trùng khớp!');
        } else {
            $user = User::getTokenSingle($token);
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(30);
            $user->save();

            return redirect(url(''))->with('success', 'Mật khẩu đã được thay đổi!');
        }
    }



    public function logout(Request $request)
    {

        Auth::logout();
        return redirect(url('/'));
    }
}
