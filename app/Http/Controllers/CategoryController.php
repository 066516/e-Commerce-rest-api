<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();
            return response()->json($categories, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching categories.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $category = Category::create([
                'name' => $request->name,
            ]);

            return response()->json($category, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while creating the category.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            return response()->json($category, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Category not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching the category.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $category->name = $request->name;
            $category->save();

            return response()->json($category, 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Category not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while updating the category.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json(null, 204);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Category not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the category.'], 500);
        }
    }

    public function categoriesWithProducts()
    {
        try {
            // Example: This method is not yet implemented. You might want to fetch categories with associated products.
            $categories = Category::with('products')->get();
            return response()->json($categories, 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching categories with products.'], 500);
        }
    }
    public function categoryWithProducts($id)
    {
        try {
            // Fetch the category with associated products
            $category = Category::with('products')->findOrFail($id);
            
            // Return JSON response with the category and its products
            return response()->json($category, 200);
    
        } catch (ModelNotFoundException $e) {
            // Handle case where category with the given $id is not found
            return response()->json(['message' => 'Category not found'], 404);
    
        } catch (\Exception $e) {
            // Handle any other exceptions that may occur
            return response()->json(['message' => 'An error occurred while fetching category with products.'], 500);
        }
    }
    
}
