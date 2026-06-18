<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->shippingAddresses()->get();
        return view('shipping_addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('shipping_addresses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'full_address' => 'required|string',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
        ]);

        Auth::user()->shippingAddresses()->create($validated);

        // If the user came from checkout, redirect back to cart
        if ($request->has('redirect_to_cart')) {
            return redirect()->route('cart.index')->with('success', 'Address added successfully! You can now checkout.');
        }

        return redirect()->route('shipping-addresses.index')->with('success', 'Address added successfully.');
    }

    public function edit(ShippingAddress $shippingAddress)
    {
        // Ensure user owns the address
        if ($shippingAddress->user_id !== Auth::id()) {
            abort(403);
        }

        return view('shipping_addresses.edit', compact('shippingAddress'));
    }

    public function update(Request $request, ShippingAddress $shippingAddress)
    {
        if ($shippingAddress->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'full_address' => 'required|string',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
        ]);

        $shippingAddress->update($validated);

        return redirect()->route('shipping-addresses.index')->with('success', 'Address updated successfully.');
    }

    public function destroy(ShippingAddress $shippingAddress)
    {
        if ($shippingAddress->user_id !== Auth::id()) {
            abort(403);
        }

        $shippingAddress->delete();

        return redirect()->route('shipping-addresses.index')->with('success', 'Address deleted successfully.');
    }
}
