<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all());
    }

    public function store(Request $request)
    {
        $request->validate([
                               'name' => 'required|string|max:255',
                               'price' => 'required|numeric|min:0',
                               'quantity' => 'required|integer|min:1',
                           ]);

        $product = Product::create($request->all());

        return response()->json(['message' => 'Product created successfully!', 'product' => $product], 201);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
                               'name' => 'string|max:255',
                               'price' => 'numeric|min:0',
                               'quantity' => 'integer|min:1',
                           ]);

        $product->update($request->all());

        return response()->json(['message' => 'Product updated successfully!', 'product' => $product]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully!']);
    }
}