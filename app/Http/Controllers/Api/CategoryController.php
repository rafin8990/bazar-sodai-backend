<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function viewCategories()
    {
        $categories = Category::all();
        return view('dashboard.Category.index', compact('categories'));
    }

    public function createCategory(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg,gif|max:2048',
        ]);

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/category_icons');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $data['icon'] = 'uploads/category_icons/' . $filename;
        }

        $category = Category::create($data);

          return redirect()->route('viewCategories')->with('success', 'Category created successfully');
    }

    public function getCategories()
    {
        $categories = Category::all();

        return response()->json([
            "success" => true,
            "message" => "Categories retrieved successfully",
            "data" => $categories
        ], 200);
    }

    public function getCategory($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                "success" => false,
                "message" => "Category not found"
            ], 404);
        }

        return response()->json([
            "success" => true,
            "message" => "Category retrieved successfully",
            "data" => $category
        ], 200);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    // Update category
    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Check if a new image is uploaded
        if ($request->hasFile('icon')) {
            // Delete old image if exists and path contains 'uploads/category_icons'
            if ($category->icon && str_contains($category->icon, 'uploads/category_icons/')) {
                // The old image path should be relative from public/
                $oldImagePath = public_path($category->icon); // no parse_url, because it's stored as relative path
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Upload new image
            $image = $request->file('icon');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/category_icons'), $imageName);

            // Save relative path to DB, NOT full url
            $data['icon'] = 'uploads/category_icons/' . $imageName;
        }

        $category->update($data);

        return redirect()->route('viewCategories')->with('success', 'Category updated successfully');
    }


    // Delete category
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);

        if ($category->icon && str_contains($category->icon, 'uploads/category_icons/')) {
            $imagePath = public_path(parse_url($category->icon, PHP_URL_PATH));
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $category->delete();

        return redirect()->route('viewCategories')->with('success', 'Category deleted successfully');
    }


}

