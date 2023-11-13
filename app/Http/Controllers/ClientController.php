<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $data = [];
        $featuredProduct = Product::where('is_featured', 'Yes')->orderBy('id', 'DESC')
            ->where('status', 1)->take(8)->get();
        $latestProduct = Product::orderBy('id', 'DESC')->where('status', 1)->take(8)->get();
        $data['featuredProduct'] = $featuredProduct;
        $data['latestProduct'] = $latestProduct;
        return view('client.home', $data);
    }

    public function addWishList(Request $request)
    {
        if (Auth::check() == false){
            session(['url.intended' => url()->previous()]);

            return response()->json([
               'status' => false,
            ]);
        }

        $product = Product::where('id', $request->id)->first();

        Wishlist::updateOrCreate([
            'user_id' => Auth::user()->id,
            'product_id' => $request->id,
        ],
        [
            'user_id' => Auth::user()->id,
            'product_id' => $request->id,
        ]);

        return response()->json([
           'status' => true,
           'message' => '<strong>'.$product->name . '</strong> Add Wishlist Success',
        ]);
    }
}
