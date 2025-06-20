<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationsController extends Controller
{
       public function index()
    {
   $locations = Location::all();
    return view('locations.index', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:locations,name']);
        $location = Location::create([
            'name' => $request->name,
        ]);
        return response()->json([
            'message' => 'Location created successfully.',
            'data' => $location,
        ], 201);
    }

    public function show($id)
    {
        $location = Location::find($id);
        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }
        return response()->json($location);
    }

    public function update(Request $request, $id)
    {
        $location = Location::find($id);
        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }
        $request->validate([
            'name' => 'required|string|unique:locations,name,' . $id,
        ]);
        $location->update(['name' => $request->name]);
        return response()->json([
            'message' => 'Location updated.',
            'data' => $location,
        ]);
    }

    public function destroy($id)
    {
        $location = Location::find($id);
        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }
        $location->delete();
        return response()->json(['message' => 'Location deleted']);
    }
}
