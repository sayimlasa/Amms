<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\AcAsset;
use App\Models\Location;
use App\Models\AcMovement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AcMovementController extends Controller
{
    public function index()
    {
        $movements = AcMovement::with(['fromLocation', 'toLocation', 'movedBy', 'acAsset'])->latest()->paginate(10);
        return view('ac_movements.index', compact('movements'));
    }

    public function create()
    {
        $locations = Location::pluck('name', 'id');
        $acAssets = AcAsset::pluck('serial_number', 'id');
        return view('ac_movements.create', compact('locations', 'acAssets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ac_id' => 'required|integer',
            'from_location_id' => 'nullable|exists:locations,id',
            'to_location_id' => 'nullable|exists:locations,id',
            'movement_type' => 'nullable|string|max:20',
            'moved_by' => 'nullable|exists:users,id',
            'remark' => 'nullable|string',
        ]);
        $validated['moved_by'] = Auth::id();
        AcMovement::create($validated);
        return redirect()->route('ac-movements.index')->with('success', 'Movement recorded successfully.');
    }

    // public function show(AcMovement $ac_movement)
    // {
    //     return view('ac_movements.show', compact('ac_movement'));
    // }

    public function edit(AcMovement $ac_movement)
    {

        $locations = Location::pluck('name', 'id');
        $acAssets = AcAsset::pluck('serial_number', 'id');
        return view('ac_movements.edit', compact('ac_movement', 'locations', 'acAssets'));
    }

    public function update(Request $request, AcMovement $ac_movement)
    {
        $validated = $request->validate([
            //'ac_id' => 'required|integer',
            'from_location_id' => 'nullable|exists:locations,id',
            'to_location_id' => 'nullable|exists:locations,id',
            'movement_type' => 'nullable|string|max:20',
            'moved_by' => 'nullable|exists:users,id',
            'remark' => 'nullable|string',
        ]);
        $validated['moved_by'] = Auth::id();
        $ac_movement->update($validated);
        return redirect()->route('ac-movements.index')->with('success', 'Movement updated successfully.');
    }
    public function show($id)
    {
        // Load the AC Movement with related data (acAsset, locations, movedBy)
        $movement = AcMovement::with(['acAsset', 'fromLocation', 'toLocation', 'movedBy'])->findOrFail($id);
        return view('ac_movements.show', compact('movement'));
    }

    public function destroy(AcMovement $ac_movement)
    {
        $ac_movement->delete();
        return redirect()->route('ac-movements.index')->with('success', 'Movement deleted successfully.');
    }
}
