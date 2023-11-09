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

        if ($request->get('price_min') != '' && $request->get('price_max') != ''){
            if ($request->get('price_max') == 1000000){
                $products = $products->whereBetween('price', [intval($request->get('price_min')), 10000000]);
            }
            else {
                $products = $products->whereBetween('price', [intval($request->get('price_min')), intval($request->get('price_max'))]);
            }
        }

        if ($request->get('sort') != ''){
            if ($request->get('sort') == 'latest'){
                $products = $products->orderBy('id', 'DESC');
            }
            elseif ($request->get('sort') == 'price_high'){
                $products = $products->orderBy('price', 'DESC');
            }
            else {
                $products = $products->orderBy('price', 'ASC');
            }
        } else {
            $products = $products->orderBy('id', 'DESC');
        }

        $products = $products->orderBy('id', 'DESC');
        $products = $products->paginate(9);

        $data['categories'] = $categories;
        $data['sizes'] = $sizes;
        $data['colors'] = $colors;
        $data['products'] = $products;
        $data['categorySelected'] = $categorySelected;
        $data['sizeArray'] = $sizeArray;
        $data['colorArray'] = $colorArray;
        $data['priceMax'] = (intval($request->get('price_max')) == 0 ? 1000000 : $request->get('price_max'));
        $data['priceMin'] = intval($request->get('price_min'));
        $data['sort'] = $request->get('sort');
        return view('client.shop', $data);
    }
}
