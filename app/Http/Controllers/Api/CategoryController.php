<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function createCategory(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        $category = Category::create($data);

        return response()->json([
            "success" => true,
            "message" => "Category created successfully",
            "data" => $category
        ], 201);
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

    public function updateCategory(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                "success" => false,
                "message" => "Category not found"
            ], 404);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        $category->update($data);

        return response()->json([
            "success" => true,
            "message" => "Category updated successfully",
            "data" => $category
        ], 200);
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                "success" => false,
                "message" => "Category not found"
            ], 404);
        }

        $category->delete();

        return response()->json([
            "success" => true,
            "message" => "Category deleted successfully"
        ], 200);
    }
    
    
}

