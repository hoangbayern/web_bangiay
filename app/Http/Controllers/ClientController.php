<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
}
