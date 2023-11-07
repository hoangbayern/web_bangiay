<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $data = [];
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $sizes = Size::orderBy('name', 'ASC')->where('status', 1)->get();
        $colors = Color::orderBy('name', 'ASC')->where('status', 1)->get();
        $products = Product::orderBy('id', 'DESC')->where('status', 1)->get();
        $data['categories'] = $categories;
        $data['sizes'] = $sizes;
        $data['colors'] = $colors;
        $data['products'] = $products;
        return view('client.shop', $data);
    }
}
