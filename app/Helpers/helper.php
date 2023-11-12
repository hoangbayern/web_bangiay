<?php
function getCategories()
{
   return \App\Models\Category::orderBy('name', 'ASC')
       ->where('status', 1)
       ->where('showHome', 'Yes')
       ->get();
}
function getProductImage($productId)
{
    return \App\Models\ProductImage::where('product_id', $productId)->first();
}
?>
