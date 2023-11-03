<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    protected Product $product;

    /**
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function showFormCreate()
    {
        $data = [];
        $categories = Category::orderBy('name', 'ASC')->get();
        $sizes = Size::orderBy('name', 'ASC')->get();
        $colors = Color::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        $data['sizes'] = $sizes;
        $data['colors'] = $colors;
        return view('admin.product.create', $data);
    }

    public function store(StoreRequest $request)
    {
        $dataProduct = $request->all();
        $sizeIds = $request->input('sizeIds');
        $colorIds = $request->input('colorIds');
        $product = $this->product->create($dataProduct);
        $product->syncSizes($sizeIds);
        $product->syncColors($colorIds);
        return response()->json([
            'data' => $product,
            'message' => 'Create Product Successfully.'
        ], Response::HTTP_OK);
    }
}
