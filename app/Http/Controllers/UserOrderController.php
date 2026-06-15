<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->with('order_details.product')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function complete(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'shipped') {
            return back()->with('error', 'Only shipped orders can be confirmed.');
        }

        $order->update(['status' => 'completed']);

        return back()->with('success', 'Order confirmed as received. Thank you!');
    }
}
