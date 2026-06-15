<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminSalesController extends Controller
{
    public function index()
    {
        // Get all completed/shipped orders (or all orders, but usually we consider revenue from paid ones)
        // For this system, as money is deducted instantly, all orders count towards total sales count.
        $orders = Order::with('user', 'order_details.product')->latest()->get();
        
        // Fetch the actual money balance from the admin's database record to ensure it is a "real" record
        $admin = \App\Models\User::where('role', 'admin')->first();
        $totalRevenue = $admin ? $admin->money : 0;
        
        $totalSales = $orders->count();

        return view('admin.sales.index', compact('orders', 'totalRevenue', 'totalSales'));
    }
}
