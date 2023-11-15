<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showForgetPasswordForm()
    {
        return view('auth.passwords.client-email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
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
        return redirect()->route('client.forgetPassword')->withErrors([
            'success' => 'We have send an email to reset password.'
        ]);
    }

    public function resetPassword($token)
    {
        return view('auth.passwords.client-new-password', compact('token'));
    }

    public function resetPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:3|max:100',
            'password_confirmation' => 'required|same:password',
        ]);
        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token,
            ])->first();
        if (!$updatePassword){
            return redirect()->route('client.resetPassword')->withErrors([
                'error' => 'Reset Password Failed.'
            ]);
        }
        User::where('email' , $request->email)->update([
            'password' => Hash::make($request->password),
        ]);
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        return redirect()->route('client.login')->withErrors([
            'success' => 'Reset Password Successfully.'
        ]);
    }
}
