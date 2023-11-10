<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
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
        $dataProduct['related_products'] = (!empty($request->related_products)) ? implode(',', $request->related_products) : '';
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

    public function showFormEdit(string $id)
    {
        $data = [];
        $product = $this->product->findOrFail($id);

        if (!isset($product)){
            return redirect()->route('product.list')->withErrors([
                'error' => 'Product not found.',
            ]);
        }
        $categories = Category::orderBy('name', 'ASC')->get();
        $sizes = Size::orderBy('name', 'ASC')->get();
        $colors = Color::orderBy('name', 'ASC')->get();
        $productImages = ProductImage::where('product_id',$product->id)->get();
        $related_products = [];
        if ($product->related_products != ''){
            $productArr = explode(',', $product->related_products);
            $related_products = $this->product->whereIn('id', $productArr)->get();
        }

        $data['productImages'] = $productImages;
        $data['product'] = $product;
        $data['categories'] = $categories;
        $data['sizes'] = $sizes;
        $data['colors'] = $colors;
        $data['related_products'] = $related_products;
        return view('admin.product.edit', compact('data'));
    }

    public function update(UpdateRequest $request, string $id)
    {
        $product = $this->product->findOrFail($id);
        $dataProduct = $request->all();

        $sizeIds = $request->input('sizeIds');
        $colorIds = $request->input('colorIds');
        $dataProduct['related_products'] = (!empty($request->related_products)) ? implode(',', $request->related_products) : '';
        $product->update($dataProduct);
        $product->syncSizes($sizeIds);
        $product->syncColors($colorIds);

        //Save Gallery
        if (!empty($request->image_array)) {
            foreach ($request->image_array as $key => $imageId) {
                $productImage = ProductImage::find($imageId);
                $productImage->save();
            }
        }

        return response()->json([
            'data' => $product,
            'message' => 'Updated Product Successfully.'
        ], Response::HTTP_OK);
    }

    public function deleteProduct(string $id)
    {
        $product = $this->product->findOrFail($id);

        $productImages = ProductImage::where('product_id', $product->id)->get();
        if (!empty($productImages)){
            foreach ($productImages as $productImage){
                File::delete(public_path('uploads/products/small/'.$productImage->image));
                File::delete(public_path('uploads/products/large/'.$productImage->image));
            }
            ProductImage::where('product_id', $product->id)->delete();
        }

        $product->delete();
        return response()->json([
            'message' => 'Product deleted successfully.'
        ], Response::HTTP_OK);
    }

    public function getProducts(Request $request)
    {
        $tempProduct = [];
        if ($request->term != ''){
            $products = $this->product->where('name', 'like', '%'.$request->term.'%')->get();
            if ($products != null){
                foreach ($products as $product){
                    $tempProduct[] = array('id' => $product->id, 'text' => $product->name);
                }
            }
        }
        return response()->json([
            'tags' => $tempProduct,
            'status' => true,
        ], Response::HTTP_OK);
    }
}
