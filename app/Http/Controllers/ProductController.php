<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::query();

    if ($request->search) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    if ($request->min_price) {
        $query->where('price', '>=', $request->min_price);
    }

    if ($request->max_price) {
        $query->where('price', '<=', $request->max_price);
    }

    $products = $query->get();

    return view('products.index', compact('products'));
}

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:30',
            'description' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $imageNames = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time().'_'.uniqid().'.'.$image->extension();
                $image->move(public_path('images'), $imageName);
                $imageNames[] = $imageName;
            }
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imageNames,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:30',
            'description' => 'required',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $imageNames = $product->image;
        if ($request->hasFile('images')) {
            // Delete old images from disk
            if (is_array($product->image)) {
                foreach ($product->image as $oldImage) {
                    if (File::exists(public_path('images/' . $oldImage))) {
                        File::delete(public_path('images/' . $oldImage));
                    }
                }
            } elseif (is_string($product->image)) {
                if (File::exists(public_path('images/' . $product->image))) {
                    File::delete(public_path('images/' . $product->image));
                }
            }

            $imageNames = [];
            foreach ($request->file('images') as $image) {
                $imageName = time().'_'.uniqid().'.'.$image->extension();
                $image->move(public_path('images'), $imageName);
                $imageNames[] = $imageName;
            }
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imageNames,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete images from disk
        if (is_array($product->image)) {
            foreach ($product->image as $oldImage) {
                if (File::exists(public_path('images/' . $oldImage))) {
                    File::delete(public_path('images/' . $oldImage));
                }
            }
        } elseif (is_string($product->image)) {
            if (File::exists(public_path('images/' . $product->image))) {
                File::delete(public_path('images/' . $product->image));
            }
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}