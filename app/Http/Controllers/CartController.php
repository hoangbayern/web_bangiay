<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

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
                $message = $product->name . ' added in cart';
                session()->flash('success', $message);
            }
            else{
                $status = false;
                $message = $product->name . ' already added in cart';
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
            $message = $product->name . ' added in cart';
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
}
