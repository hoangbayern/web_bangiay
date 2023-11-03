<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authenticate\LoginRequest;
use App\Http\Requests\Authenticate\RegisterRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    protected Admin $admin;

    /**
     * @param Admin $admin
     */
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    /**
     * Show Form Login Admin
     */
    public function showLoginForm()
    {
        if(Auth::guard('admin')->check()){
            return redirect('/admin');
        }
        return view('auth.admin-login');
    }

    /**
     * Admin login.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            return redirect()->route('adminHome')->withErrors([
                'success' => 'Logged in successfully',
            ]);
        }
        return redirect()->route('admin.login')->withErrors([
            'errorLogin' => 'The email or password you entered is incorrect.',
        ]);
    }

    /**
     * Show Form Register Admin
     */
    public function showRegisterForm()
    {
        if(Auth::guard('admin')->check()){
            return redirect('/admin');
        }
        return view('auth.admin-register');
    }

    public function register(RegisterRequest $request)
    {
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        unset($data['confirm_password']); // Xóa trường 'confirm_password'
        Admin::create($data);
        return redirect()->route('admin.login')->withErrors([
            'success' => 'The account has been successfully registered.',
        ]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->withErrors([
            'success' => 'The account has been logged out.',
        ]);
    }

}
