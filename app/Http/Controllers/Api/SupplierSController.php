<?php

namespace App\Http\Controllers\Api;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierSController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }
    public function create()
    {
        return view('suppliers.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:suppliers,name',
            'physical_address' => 'nullable|string',
            'mobile' => 'nullable|string|max:15',
        ]);
        $supplier = Supplier::create($request->all());
        return response()->json([
            'message' => 'Supplier created successfully',
            'data' => $supplier,
        ], 201);
    }

    public function show($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }
        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }
        $request->validate([
            'name' => 'required|string|unique:suppliers,name,' . $id,
            'physical_address' => 'nullable|string',
            'mobile' => 'nullable|string|max:15',
        ]);
        $supplier->update($request->all());
        return response()->json([
            'message' => 'Supplier updated',
            'data' => $supplier,
        ]);
    }

    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }
        $supplier->delete();
        return response()->json(['message' => 'Supplier deleted']);
    }
}
