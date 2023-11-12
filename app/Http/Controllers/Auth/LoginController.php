<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authenticate\LoginRequest;
use App\Http\Requests\Authenticate\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected User $user;

    /**
     * @param User|string $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function showLoginForm()
    {
        return view('auth.client-login');
    }

    public function loginClient(LoginRequest $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (session()->has('url.intended')){
                return redirect(session()->get('url.intended'));
            }
            return redirect()->route('client.profile')->withErrors([
                'success' => 'Logged in successfully.'
            ]);
        }
        return redirect()->route('client.login')->withErrors([
            'errorLogin' => 'The email or password you entered is incorrect.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function registerClient(RegisterRequest $request)
    {
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        unset($data['confirm_password']);
        $this->user->create($data);
        return redirect()->route('client.login')->withErrors([
            'success' => 'The account has been successfully registered.',
        ]);
    }

    public function profile()
    {
        return view('client.account.profile');
    }

    public function logoutClient()
    {
        Auth::logout();
        return redirect()->route('client.login')->withErrors([
            'success' => 'The account has been logged out.',
        ]);
    }

}
