<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProductImageController extends Controller
{
    public function update(Request $request)
    {
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();

        $productImage = new ProductImage();
        $productImage->image = 'NULL';
        $productImage->product_id = $request->product_id;
        $productImage->save();

        $imageName = $request->product_id.'-'.$productImage->id.'-'.time().'.'.$ext;
        $productImage->image = $imageName;
        $productImage->save();

        // Small Image
        $sourcePath = $image->getPathName();;
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

        return response()->json([
            'status' => true,
            'image_id' => $productImage->id,
            'name' => $imageName,
            'imagePath' => asset('uploads/products/small/'.$imageName)
        ]);
    }

    public function destroy(string $id)
    {
        $image = ProductImage::find($id);

        File::delete(public_path('uploads/products/small/'.$image->image));
        File::delete(public_path('uploads/products/large/'.$image->image));

        $image->delete();

        return response()->json([
            'message' => 'Image deleted successfully',
        ], Response::HTTP_OK);
    }
}
