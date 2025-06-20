<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandsController extends Controller
{
     // GET /api/brands
    public function index()
    {
       $brands = Brand::all();
    return view('brands.index', compact('brands'));
    }

    // POST /api/brands
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:brands,name',
        ]);
        $brand = Brand::create([
            'name' => $request->name,
        ]);
        return response()->json([
            'message' => 'Brand created successfully',
            'data' => $brand,
        ], 201);
    }

    // GET /api/brands/{id}
    public function show($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }
        return response()->json($brand);
    }

    // PUT /api/brands/{id}
    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }
        $request->validate([
            'name' => 'required|string|unique:brands,name,' . $id,
        ]);
        $brand->update(['name' => $request->name]);
        return response()->json(['message' => 'Brand updated', 'data' => $brand]);
    }

    // DELETE /api/brands/{id}
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }
        $brand->delete();
        return response()->json(['message' => 'Brand deleted']);
    }
}
