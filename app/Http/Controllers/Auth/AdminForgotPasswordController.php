<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AdminForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;
    public function showResetPasswordForm()
    {
        return view('auth.passwords.email-admin');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($status)
            : $this->sendResetLinkFailedResponse($request, $status);
    }
}
