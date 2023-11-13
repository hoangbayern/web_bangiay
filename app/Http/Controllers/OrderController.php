<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    protected Order $order;

    /**
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function listOrder()
    {
        return view('admin.order.list');
    }

    public function search(Request $request)
    {
        $orders = $this->order->search($request->name);
        $view = view('admin.order.table', compact('orders'))->render();
        return response()->json([
            'table' => $view,
        ], Response::HTTP_OK);
    }

    public function detail(string $orderId)
    {
        $data = [];
        $order = $this->order->where('id', $orderId)->first();
        $orderItems = OrderItem::where('order_id', $orderId)->get();
        $data['order'] = $order;
        $data['orderItems'] = $orderItems;
        return view('admin.order.detail', $data);
    }

    public function changeOrderStatus(string $orderId, Request $request)
    {
        $order = $this->order->findOrFail($orderId);
        $order->status = $request->status;
        $order->save();

        session()->flash('success', 'Order Status Updated Successfully.');
        return response()->json([
           'status' => true,
           'message' => 'Updated Status Successfully.',
        ]);
    }
}
