<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        if (!empty($request->get('search'))){
            $products = $products->where('name', 'like', '%'.$request->get('search').'%');
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

        if ($request->get('gender') != ''){
            if ($request->get('gender') == 'gender_male'){
                $products = $products->where('gender', 1);
            }
            elseif ($request->get('gender') == 'gender_female'){
                $products = $products->where('gender', 0);
            }
            else {
                $products = $products->orderBy('id', 'DESC');
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
        $data['gender'] = $request->get('gender');
        return view('client.shop', $data);
    }

    public function product($productName)
    {
        $data = [];
        $product = Product::where('name', $productName)
                            ->withCount('product_ratings')
                            ->withSum('product_ratings', 'rating')
                            ->with(['product_images', 'product_ratings' => function ($query) {
                                     $query->orderBy('id', 'DESC'); // Sắp xếp product_ratings theo id giảm dần
                                 }])
                            ->first();
//        dd($product);
        if ($product == null){
            abort(404);
        }
        $related_products = [];
        if ($product->related_products != ''){
            $productArr = explode(',', $product->related_products);
            $related_products = Product::whereIn('id', $productArr)->where('status', 1)->with('product_images')->get();
        }
        $data['product'] = $product;
        $data['related_products'] = $related_products;
        return view('client.product', $data);
    }

    public function saveRating(Request $request, $productId)
    {
        $validator = Validator::make($request->all(), [
           'username' => 'required',
           'email' => 'required',
           'comment' => 'required',
           'rating' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json([
               'status' => false,
               'errors' => $validator->errors(),
            ]);
        }

        $count = ProductRating::where('email', $request->email)->count();
        if ($count > 0){
            session()->flash('warning', 'You already rated this product.');
            return response()->json([
               'status' => true,
            ]);
        }

            $productRating = new ProductRating();
            $productRating->username = $request->username;
            $productRating->email = $request->email;
            $productRating->rating = $request->rating;
            $productRating->comment = $request->comment;
            $productRating->product_id = $productId;
            $productRating->save();

            session()->flash('success', 'Thanks for your rating.');

        return response()->json([
            'status' => true,
            'message' => 'Rated created successfully',
            'data' => $productRating,
        ]);
    }
}
