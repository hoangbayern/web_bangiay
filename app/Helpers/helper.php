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

function orderEmail($orderId)
{
    $order = \App\Models\Order::where('id', $orderId)->with('items')->first();

    $mailData = [
        'subject' => 'Shoes Store | Thank You for Your Order!',
        'order' => $order,
    ];
    \Illuminate\Support\Facades\Mail::to($order->email)->send(new \App\Mail\OrderEmail($mailData));
}
?>
