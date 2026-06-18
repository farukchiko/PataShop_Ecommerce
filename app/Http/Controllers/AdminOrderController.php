<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'order_details.product', 'shippingAddress'])->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,packing,shipped,completed',
        ]);

        $updateData = ['status' => $request->status];

        // If status changed to shipped, set the shipped_at timestamp
        if ($request->status === 'shipped' && $order->status !== 'shipped') {
            $updateData['shipped_at'] = now();
        }

        $order->update($updateData);

        return back()->with('success', 'Order status updated successfully!');
    }
}
