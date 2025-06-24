<?php

namespace App\Http\Controllers;

use App\Models\AcAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $query = AcAsset::query();
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('warranty_expiry_date', [$request->start_date, $request->end_date]);
        }
        $assets = $query->with('location')->get();

        $expiredCount = AcAsset::where('warranty_expiry_date', '<', Carbon::today())->count();
        $expiringSoonCount = AcAsset::whereBetween('warranty_expiry_date', [Carbon::today(), Carbon::today()->addDays(5)])->count();

        return view('reports.index', compact('assets', 'expiredCount', 'expiringSoonCount'));
    }
    public function sample(){
        return view('reports.sample');
    }
}
