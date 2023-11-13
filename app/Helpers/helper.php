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

function orderEmail($orderId, $typeUser = 'customer')
{
    $order = \App\Models\Order::where('id', $orderId)->with('items')->first();

    if ($typeUser == 'admin'){
        $subject = 'Shoes Store | You have received an New Order!';
        $email = env('ADMIN_EMAIL');
    }
    else {
        $subject = 'Shoes Store | Thank You for Your Order!';
        $email = $order->email;
    }

    $mailData = [
        'subject' => $subject,
        'order' => $order,
        'typeUser' => $typeUser,
    ];
    \Illuminate\Support\Facades\Mail::to($email)->send(new \App\Mail\OrderEmail($mailData));
}
?>
