<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address_id' => 'required|exists:shipping_addresses,id',
        ]);

        $user = Auth::user();

        // Verify the address belongs to the user
        $address = $user->shippingAddresses()->find($request->shipping_address_id);
        if (!$address) {
            return back()->with('error', 'Invalid shipping address selected.');
        }

        $carts = $user->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $totalPrice = 0;

        foreach ($carts as $cart) {
            if ($cart->product->stock < $cart->quantity) {
                return back()->with('error', 'Insufficient stock for product: ' . $cart->product->name);
            }
            $totalPrice += $cart->product->price * $cart->quantity;
        }

        if ($user->money < $totalPrice) {
            return back()->with('error', 'Insufficient money.');
        }

        DB::beginTransaction();

        try {
            // Deduct money from user
            $user->money -= $totalPrice;
            $user->save();

            // Transfer money to Admin
            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                $admin->money += $totalPrice;
                $admin->save();
            }

            // Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'shipping_address_id' => $address->id,
            ]);

            // Create Order Details and Deduct Stock
            foreach ($carts as $cart) {
                $order->order_details()->create([
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                ]);

                $cart->product->decrement('stock', $cart->quantity);
            }

            // Clear Cart
            $user->carts()->delete();

            DB::commit();

            return redirect()->route('storefront.index')->with('success', 'Checkout successful! Enjoy your sweet treats.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred during checkout. Please try again.');
        }
    }
}
