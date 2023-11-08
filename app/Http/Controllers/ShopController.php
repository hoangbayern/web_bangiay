<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug = null)
    {
        $categorySelected = '';
        $data = [];
        $sizeArray = [];
        $colorArray = [];

        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $sizes = Size::orderBy('name', 'ASC')->where('status', 1)->get();
        $colors = Color::orderBy('name', 'ASC')->where('status', 1)->get();
        $products = Product::where('status', 1);

        if (!empty($categorySlug)){
            $category = Category::where('name', $categorySlug)->first();
            $products = $products->where('category_id', $category->id);
            $categorySelected = $category->id;
        }

        if (!empty($request->get('size'))){
            $sizeArray = explode(',', $request->get('size'));
            $products = $products->whereHas('sizes', function ($query) use ($sizeArray) {
                $query->whereIn('sizes.id', $sizeArray);
            });
        }

        if (!empty($request->get('color'))){
            $colorArray = explode(',', $request->get('color'));
            $products = $products->whereHas('colors', function ($query) use ($colorArray) {
                $query->whereIn('colors.id', $colorArray);
            });
        }

        if ($request->get('price_min') !== '' && $request->get('price_max') !== ''){
            $products = $products->whereBetween('price', [$request->get('price_min'), $request->get('price_max')]);
        }

        $products = $products->orderBy('id', 'DESC');
        $products = $products->get();

        $data['categories'] = $categories;
        $data['sizes'] = $sizes;
        $data['colors'] = $colors;
        $data['products'] = $products;
        $data['categorySelected'] = $categorySelected;
        $data['sizeArray'] = $sizeArray;
        $data['colorArray'] = $colorArray;
        return view('client.shop', $data);
    }
}
