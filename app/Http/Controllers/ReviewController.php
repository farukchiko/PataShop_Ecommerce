<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Order $order, Product $product)
    {
        // Check if order belongs to user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Check if order is completed
        if ($order->status !== 'completed') {
            return redirect()->route('orders.index')->with('error', 'You can only review products from completed orders.');
        }

        // Check if product is in the order
        $hasProduct = $order->order_details()->where('product_id', $product->id)->exists();
        if (!$hasProduct) {
            abort(403, 'Product not found in this order.');
        }

        // Check if already reviewed
        $existingReview = Review::where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return redirect()->route('orders.index')->with('error', 'You have already reviewed this product for this order.');
        }

        return view('reviews.create', compact('order', 'product'));
    }

    public function store(Request $request, Order $order, Product $product)
    {
        // Authorization & state checks
        if ($order->user_id !== Auth::id() || $order->status !== 'completed') {
            abort(403);
        }

        $hasProduct = $order->order_details()->where('product_id', $product->id)->exists();
        if (!$hasProduct) {
            abort(403);
        }

        $existingReview = Review::where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return redirect()->route('orders.index')->with('error', 'Review already exists.');
        }

        // Validation
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'media' => 'nullable|array|max:10',
            'media.*' => 'file|mimes:jpeg,png,jpg,mp4,mov,avi|max:10240', // Max 10MB per file
        ]);

        $mediaPaths = [];
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $fileName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('reviews'), $fileName);
                $mediaPaths[] = $fileName;
            }
        }

        // Create review
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'media_paths' => !empty($mediaPaths) ? $mediaPaths : null,
        ]);

        return redirect()->route('orders.index')->with('success', 'Thank you! Your review has been submitted.');
    }

    public function edit(Review $review)
    {
        // Must belong to user
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        // Must be within 24 hours
        if (now()->diffInHours($review->created_at) > 24) {
            return redirect()->route('storefront.show', $review->product_id)->with('error', 'Reviews can only be edited within 24 hours of posting.');
        }

        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        // Authorization & state checks
        if ($review->user_id !== Auth::id() || now()->diffInHours($review->created_at) > 24) {
            abort(403);
        }

        // Validation
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'media' => 'nullable|array|max:10',
            'media.*' => 'file|mimes:jpeg,png,jpg,mp4,mov,avi|max:10240',
        ]);

        $mediaPaths = $review->media_paths; // Keep old by default

        if ($request->hasFile('media')) {
            // Delete old media (optional, but good practice. We skip deletion here for simplicity)
            $mediaPaths = [];
            foreach ($request->file('media') as $file) {
                $fileName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('reviews'), $fileName);
                $mediaPaths[] = $fileName;
            }
        }

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'media_paths' => !empty($mediaPaths) ? $mediaPaths : null,
        ]);

        return redirect()->route('storefront.show', $review->product_id)->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id() || now()->diffInHours($review->created_at) > 24) {
            abort(403);
        }

        $productId = $review->product_id;
        $review->delete();

        return redirect()->route('storefront.show', $productId)->with('success', 'Review deleted successfully.');
    }

    public function destroyAdmin(Review $review)
    {
        // Check if admin
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $productId = $review->product_id;
        $review->delete();

        return back()->with('success', 'Review deleted by Admin.');
    }
}
