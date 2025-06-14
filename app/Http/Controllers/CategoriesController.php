<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Categories;
use App\Models\Product;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum'); // Wajib token
    }

    // GET /api/categories
    public function index()
    {
        return response()->json(Categories::all());
    }

    // POST /api/categories
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|string|exists:products,product_id',
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = Categories::create([
            'category_id' => (string) Str::ulid(),
            'product_id' => $request->product_id,
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json($category, 201);
    }

    // GET /api/categories/{id}
    public function show($id)
    {
        $category = Categories::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($category);
    }

    // PUT /api/categories/{id}
    public function update(Request $request, $id)
    {
        $category = Categories::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'product_id' => 'sometimes|string|exists:products,product_id',
            'name' => 'sometimes|string',
            'description' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category->update($request->only(['product_id', 'name', 'description']));

        return response()->json($category);
    }

    // DELETE /api/categories/{id}
    public function destroy($id)
    {
        $category = Categories::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted']);
    }
}
