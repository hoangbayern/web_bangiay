<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AdminForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;
    public function showForgetPasswordForm()
    {
        return view('auth.passwords.email-admin');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
           'email' => 'required|email|exists:admins',
        ]);
        $token = Str::random(40);
        DB::table('password_resets')->insert([
           'email' => $request->email,
           'token' => $token,
           'created_at' => Carbon::now(),
        ]);
        Mail::send('emails.forget-password', ['token'=> $token],function ($message) use ($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        return redirect()->route('admin.forgetPassword')->withErrors([
                'success' => 'We have send an email to reset password.'
        ]);
    }

    public function resetPassword($token)
    {
        return view('auth.passwords.new-password', compact('token'));
    }

    public function resetPasswordPost(Request $request)
    {
        $request->validate([
           'email' => 'required|email|exists:admins',
            'password' => 'required|min:3|max:100',
            'password_confirmation' => 'required|same:password',
        ]);
        $updatePassword = DB::table('password_resets')
            ->where([
               'email' => $request->email,
               'token' => $request->token,
            ])->first();
        if (!$updatePassword){
            return redirect()->route('admin.resetPassword')->withErrors([
                'error' => 'Reset Password Failed.'
            ]);
        }
        Admin::where('email' , $request->email)->update([
            'password' => Hash::make($request->password),
        ]);
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        return redirect()->route('admin.login')->withErrors([
           'success' => 'Reset Password Successfully.'
        ]);
    }

}
