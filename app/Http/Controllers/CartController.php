<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
}
