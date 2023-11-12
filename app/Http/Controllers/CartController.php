<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\CustomerAddresses;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Size;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addCart(Request $request)
    {
        $product = Product::with('product_images')->findOrFail($request->id);

        if ($product == null) {
            return response()->json([
                'message' => 'Product not found',
                'status' => false,
            ]);
        }

        $sizeId = $request->input('size');
        $colorId = $request->input('color');

        $sizeName = Size::findOrFail($sizeId)->name;
        $colorName = Color::findOrFail($colorId)->name;

        if (Cart::count() > 0) {
            $cartContent = Cart::content();
            $productExistCart = false;
            foreach ($cartContent as $item){
                if ($item->id == $product->id){
                    $productExistCart = true;
                }
            }
            if ($productExistCart == false){
                Cart::add(
                    $product->id,
                    $product->name,
                    1,
                    $product->price,
                    [
                        'productImage' => $product->product_images->first(),
                        'size' => ['id' => $sizeId, 'name' => $sizeName],
                        'color' => ['id' => $colorId, 'name' => $colorName],
                    ]
                );
                $status = true;
                $message = '<strong>'.$product->name . '</strong> added in your cart successfully';
                session()->flash('success', $message);
            }
            else{
                $status = false;
                $message = $product->name . ' already added in your cart';
            }
        } else {
            Cart::add(
                $product->id,
                $product->name,
                1,
                $product->price,
                [
                    'productImage' => $product->product_images->first(),
                    'size' => ['id' => $sizeId, 'name' => $sizeName],
                    'color' => ['id' => $colorId, 'name' => $colorName],
                ]
            );
            $status = true;
            $message = '<strong>'.$product->name . '</strong> added in your cart successfully';
            session()->flash('success', $message);
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function cart()
    {
        $cartContent = Cart::content();
//        dd($cartContent);
        $data['cartContent'] = $cartContent;
        return view('client.cart', $data);
    }

    public function updateCart(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;
        Cart::update($rowId, $qty);

        $message = 'Cart Updated Successfully.';
        session()->flash('success', $message);
        return response()->json([
            'status' => true,
            'message' => 'Cart Updated Successfully'
        ], Response::HTTP_OK);
    }

    public function deleteItemCart(Request $request)
    {
        $rowId = $request->rowId;
        Cart::remove($rowId);
        $status = true;
        $message = 'Delete Cart Success';
        return response()->json([
           'status' => $status,
           'message' => $message,
        ]);
    }

    public function checkout()
    {
        if (Cart::count() == 0){
            return redirect()->route('client.cart');
        }
        if (Auth::check() == false){
            if (!session()->has('url.intended')){
                session(['url.intended' => url()->current()]);
            }
            return redirect()->route('client.login');
        }
        return view('client.checkout');
    }

    public function processCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'full_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'address' => 'required',
        ]);
        if ($validator->fails()){
            return response()->json([
               'message' => 'Fix Validate Error',
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $user = Auth::user();
        CustomerAddresses::updateOrCreate(
            ['user_id' => $user->id],
            [
             'user_id' => $user->id,
             'full_name' => $request->full_name,
             'phone' => $request->phone,
             'email' => $request->email,
             'province' => $request->province_name,
             'district' => $request->district_name,
             'ward' => $request->ward_name,
             'address' => $request->address,
             'notes' => $request->notes,
            ]
        );

        //Insert data in orders table
        $subTotal = floatval(str_replace(',', '', Cart::subtotal()));
        $shipping = (Cart::count() > 0) ? 30000 : 0;
        $grandTotal = $subTotal + $shipping;

        $order = new Order();
        $order->subtotal = $subTotal;
        $order->shipping = $shipping;
        $order->grand_total = $grandTotal;
        $order->user_id = $user->id;
        $order->full_name = $request->full_name;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->province = $request->province_name;
        $order->district = $request->district_name;
        $order->ward = $request->ward_name;
        $order->address = $request->address;
        $order->notes = $request->notes;
        $order->save();

//        Insert data in item order table
        foreach (Cart::content() as $item)
        {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->name = $item->name;
            if(isset($item->options->size['name'])){
                $orderItem->size = $item->options->size['name'];
            }
            if(isset($item->options->color['name'])){
                $orderItem->color = $item->options->color['name'];
            }
            $orderItem->qty = $item->qty;
            $orderItem->price = $item->price;
            $orderItem->total = $item->price * $item->qty;
            $orderItem->save();
        }

        Cart::destroy();

        return response()->json([
           'message' => 'Order successfully.',
            'status' => true,
            'orderId' => $order->id,
        ]);
    }

    public function thankOrder($orderId)
    {
        return view('client.thanks', [
            'orderId' => $orderId
        ]);
    }
}
