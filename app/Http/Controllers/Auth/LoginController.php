<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authenticate\LoginRequest;
use App\Http\Requests\Authenticate\RegisterRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Profile;
use App\Models\User;
use App\Models\Wishlist;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        $user = $this->user->where('id', Auth::user()->id)->with('profile')->first();
        return view('client.account.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(),[
           'name' => 'required',
           'email' => 'required|email|unique:users,email,'.$userId.',id',
            'phone' => 'required',
        ]);
        if ($validator->passes()){
            $user = User::findOrFail($userId);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            Profile::updateOrCreate(
                ['user_id' => $userId],
                [
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'birthday' => $request->birthday,
                    'address' => $request->address,
                ]
            );

            session()->flash('success', 'Updated Profile Successfully');
            return response()->json([
               'status' => true,
               'message' => 'Updated Profile Successfully',
            ]);
        }
        else {
            return response()->json([
               'status' => false,
               'errors' => $validator->errors(),
            ]);
        }
    }

    public function logoutClient()
    {
        Auth::logout();
        return redirect()->route('client.login')->withErrors([
            'success' => 'The account has been logged out.',
        ]);
    }

    public function myOrders()
    {
        $user = Auth::user();
        $myOrders = Order::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
        $data['myOrders'] = $myOrders;
        return view('client.account.my-orders', $data);
    }

    public function myOrderDetail($orderId)
    {
        $data = [];
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->where('id', $orderId)->first();
        $orderItems = OrderItem::where('order_id', $orderId)->get();
        $data['order'] = $order;
        $data['orderItems'] = $orderItems;
        return view('client.account.order-detail', $data);
    }

    public function wishlist()
    {
        $data = [];
        $wishlists = Wishlist::where('user_id', Auth::user()->id)->get();
        $data['wishlists'] = $wishlists;
        return view('client.account.wishlist', $data);
    }

    public function removeItemWishlist(Request $request)
    {
        $removeItem = Wishlist::where('id', $request->id)->where('user_id', Auth::user()->id)->first();
        $removeItem->delete();

        session()->flash('success', 'Deleted Item Wishlist Success');
        return response()->json([
           'status' => true,
           'message' => 'Deleted Item Wishlist Success',
        ]);
    }

}
