<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use App\Models\AcAsset;
use App\Models\Location;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AcAssetsController extends Controller
{
    public function getReference($id): JsonResponse
    {
        $asset = AcAsset::findOrFail($id);
        return response()->json([
            'reference_number' => $asset->reference_number,
        ]);
    }
    public function indexs()
    {
        // Get the logged-in user (optional, if you need user-specific data)
        $user = Auth::user();
        // Retrieve the token from the session
        $token = Session::get('api_token');
        if (!$token) {
            Log::error('API token is missing from session.');
            return redirect()->route('login')->withErrors(['message' => 'Authentication token missing. Please log in again.']);
        }
        // Prepare and execute the API request
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'http://localhost/Amms/api/ac-assets',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Authorization: Bearer ' . $token,
            ],
        ]);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        // Decode response
        $assets = json_decode($response, true);
        // Log and handle API errors
        if ($httpCode !== 200 || isset($assets['message']) && $assets['message'] === 'Unauthenticated.') {
            Log::error('API request failed or token is invalid. Response: ' . $response);
            return redirect()->route('login')->withErrors(['message' => 'API authentication failed. Please log in again.']);
        }
        Log::info('Assets fetched successfully: ' . json_encode($assets));
        // Return view with assets
        return view('ac_assets.index', compact('assets'));
    }
    public function index()
    {
        $assets = AcAsset::all();
        return view('ac_assets.index', compact('assets'));
    }

    public function storeapi(Request $request)
    {
        $validated = $request->validate([
            'serial_number' => 'required|string|max:200|unique:ac_assets',
            'reference_number' => 'nullable|string|max:200',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'brand_id' => 'nullable|exists:brands,id',
            'warranty_expiry_date' => 'nullable|string|max:200',
            'warranty_number' => 'nullable|string|max:200',
            'model' => 'nullable|string|max:200',
            'type' => 'nullable|string|max:200',
            'capacity' => 'nullable|string|max:200',
            'derivery_note_number' => 'nullable|string|max:200',
            'derivery_note_date' => 'nullable|date',
            'lpo_no' => 'nullable|string|max:100',
            'invoice_date' => 'nullable|date',
            'invoice_no' => 'nullable|string|max:200',
            'installation_date' => 'nullable|date',
            'installed_by' => 'nullable|string|max:200',
            'condition' => 'required|in:New,Mid-used,Old',
            'status' => 'required|in:Working,Under Repair,Scrapped',
            'location_id' => 'nullable|exists:locations,id',
            'justification_form_no' => 'nullable|string|max:200',
            'created_by' => 'nullable|exists:users,id',
        ]);

        $asset = AcAsset::create($validated);
        return response()->json(['message' => 'AC Asset stored successfully.', 'data' => $asset], 201);
    }
    public function create()
    {
        $suppliers = Supplier::all();
        $locations = Location::all();
        $brands = Brand::all();
        return view('ac_assets.create', compact('suppliers', 'locations', 'brands'));
    }
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'serial_number' => 'required|string|max:200|unique:ac_assets',
            'reference_number' => 'nullable|string|max:200',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'brand_id' => 'nullable|exists:brands,id',
            'warranty_expiry_date' => 'nullable|string|max:200',
            'warranty_number' => 'nullable|string|max:200',
            'model' => 'nullable|string|max:200',
            'type' => 'nullable|string|max:200',
            'capacity' => 'nullable|string|max:200',
            'derivery_note_number' => 'nullable|string|max:200',
            'derivery_note_date' => 'nullable|date',
            'lpo_no' => 'nullable|string|max:100',
            'invoice_date' => 'nullable|date',
            'invoice_no' => 'nullable|string|max:200',
            // 'installation_date' => 'nullable|date',
            // 'installed_by' => 'nullable|string|max:200',
            'condition' => 'required|in:New,Mid-used,Old',
            'status' => 'required|in:Working,Under Repair,Scrapped',
            'location_id' => 'nullable|exists:locations,id',
            'justification_form_no' => 'nullable|string|max:200',
            'created_by' => 'nullable|exists:users,id',
        ]);
        // Create the asset
        AcAsset::create($validated);
        // Redirect back with a success message
        return redirect()->route('ac-assets.index')->with('success', 'Asset created successfully!');
    }

    // public function show($id)
    // {
    //     $asset = AcAsset::with(['supplier', 'brand', 'location'])->find($id);
    //     if (!$asset) {
    //         return response()->json(['message' => 'Asset not found.'], 404);
    //     }
    //     return response()->json($asset);
    // }



    public function show($id)
    {
        // Load asset with its movements and related models
        $asset = AcAsset::with([
            'movements.fromLocation',
            'movements.toLocation',
            'movements.movedBy',
        ])->findOrFail($id);

        // Latest movement shows current location
        $latestMovement = $asset->movements()->latest('created_at')->first();

        return view('reports.show', [
            'asset' => $asset,
            'currentLocation' => $latestMovement ? $latestMovement->toLocation : null,
            'movements' => $asset->movements()->orderBy('created_at')->get(),
        ]);
    }

    public function edit(AcAsset $acAsset)
    {
        $locations = Location::all();
        return view('ac_assets.edit', [
            'asset' => $acAsset,
            'locations' => $locations
        ]);
    }
    public function update(Request $request, $id)
    {
        // Validate inputs
        $validated = $request->validate([
            'serial_number' => 'required|string|max:255',
            'model'         => 'required|string|max:255',
            'type'          => 'required|string|max:255',
            'condition'     => 'required|in:New,Good,Fair,Poor',
            'status'        => 'required|in:Active,Inactive,Under Repair',
            'location_id'   => 'required|exists:locations,id',
        ]);

        // Find asset and update
        $asset = AcAsset::findOrFail($id);
        $asset->serial_number = $validated['serial_number'];
        $asset->model = $validated['model'];
        $asset->type = $validated['type'];
        $asset->condition = $validated['condition'];
        $asset->status = $validated['status'];
        $asset->location_id = $validated['location_id'];
        $asset->save();
        // Redirect back with success message
        return redirect()->route('ac-asset.index')
            ->with('success', 'AC Asset updated successfully.');
    }
    public function updateapi(Request $request, $id)
    {
        $asset = AcAsset::find($id);
        if (!$asset) {
            return response()->json(['message' => 'Asset not found.'], 404);
        }
        $validated = $request->validate([
            'serial_number' => 'required|string|max:200|unique:ac_assets,serial_number,' . $id,
            'reference_number' => 'nullable|string|max:200',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'brand_id' => 'nullable|exists:brands,id',
            'warranty_expiry_date' => 'nullable|string|max:200',
            'warranty_number' => 'nullable|string|max:200',
            'model' => 'nullable|string|max:200',
            'type' => 'nullable|string|max:200',
            'capacity' => 'nullable|string|max:200',
            'derivery_note_number' => 'nullable|string|max:200',
            'derivery_note_date' => 'nullable|date',
            'lpo_no' => 'nullable|string|max:100',
            'invoice_date' => 'nullable|date',
            'invoice_no' => 'nullable|string|max:200',
            'installation_date' => 'nullable|date',
            'installed_by' => 'nullable|string|max:200',
            'condition' => 'required|in:New,Mid-used,Old',
            'status' => 'required|in:Working,Under Repair,Scrapped',
            'location_id' => 'nullable|exists:locations,id',
            'justification_form_no' => 'nullable|string|max:200',
            'created_by' => 'nullable|exists:users,id',
        ]);
        $asset->update($validated);
        return response()->json(['message' => 'Asset updated successfully.', 'data' => $asset]);
    }

    public function destroy($id)
    {
        $asset = AcAsset::find($id);
        if (!$asset) {
            return response()->json(['message' => 'Asset not found.'], 404);
        }
        $asset->delete();
        return response()->json(['message' => 'Asset deleted.']);
    }
}
