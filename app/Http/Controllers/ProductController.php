<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;

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

    public function listProduct()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('admin.product.list', compact('categories'));
    }

    public function search(Request $request)
    {
        $products = $this->product->search($request->all());
        $view = view('admin.product.table', compact('products'))->render();
        return response()->json([
            'table' => $view,
        ], Response::HTTP_OK);
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

        //Save Gallery
        if (!empty($request->image_array)) {
            foreach ($request->image_array as $key => $imageId) {

                $tempImage = TempImage::find($imageId);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);

                $productImage = new ProductImage();
                $productImage->image = 'NULL';
                $productImage->product_id = $product->id;
                $productImage->save();

                $imageName = $product->id.'-'.$productImage->id.'-'.time().'.'.$ext;
                $productImage->image = $imageName;
                $productImage->save();

                // Small Image
                $sourcePath = public_path('uploads/temp/'.$tempImage->name);
                $destPath = public_path('uploads/products/small/'.$imageName);
                $img = Image::make($sourcePath);
                $img->fit(350,300);
                $img->save($destPath);

                // Large Image
                $destPath = public_path('uploads/products/large/'.$imageName);
                $img = Image::make($sourcePath);
                $img->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($destPath);

            }
        }

        return response()->json([
            'data' => $product,
            'message' => 'Create Product Successfully.'
        ], Response::HTTP_OK);
    }
}
