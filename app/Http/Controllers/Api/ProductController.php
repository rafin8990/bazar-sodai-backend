<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function viewProducts()
    {
        $categories = Category::all();
        if ($categories->isEmpty()) {
            return redirect()->route('viewCategories')->with('error', 'No categories available. Please create a category first.');
        }

        $products = Product::with('category')->get();
        return view('dashboard.Product.index', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'original_price' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image',
            'weight' => 'nullable|string',
            'nutritional_info' => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/products'), $imageName);
            $imagePath = 'uploads/products/' . $imageName;
        }

        Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'original_price' => $data['original_price'],
            'category_id' => $data['category_id'],
            'image' => $imagePath,
            'weight' => $data['weight'],
            'nutritional_info' => $data['nutritional_info'],
            'in_stock' => $request->has('in_stock'),
            'is_top_selling' => $request->has('is_top_selling'),
            'is_new_arrival' => $request->has('is_new_arrival'),
            'is_featured' => $request->has('is_featured'),
        ]);

        return redirect()->route('viewProducts')->with('success', 'Product created successfully.');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'original_price' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'weight' => 'nullable|string',
            'nutritional_info' => 'nullable|string',
        ]);

        // Handle new image upload
        if ($request->hasFile('image')) {
            if ($product->image && File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destination = public_path('uploads/products');
            $image->move($destination, $imageName);
            $product->image = 'uploads/products/' . $imageName;
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'category_id' => $request->category_id,
            'weight' => $request->weight,
            'nutritional_info' => $request->nutritional_info,
            'in_stock' => $request->has('in_stock'),
            'is_top_selling' => $request->has('is_top_selling'),
            'is_new_arrival' => $request->has('is_new_arrival'),
            'is_featured' => $request->has('is_featured'),
        ]);

        return redirect()->route('viewProducts')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('viewProducts')->with('success', 'Product deleted successfully.');
    }

    public function getAllProducts(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('category')) {
            $query->where('category_id', $request->query('category'));
        }

        $products = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Products retrieved successfully.',
            'data' => $products
        ]);
    }

    public function getProduct($id)
    {
        $product = Product::with('category')->find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }
        return response()->json(['success' => true, 'message' => 'Product retrieved successfully.', 'data' => $product]);
    }
}
