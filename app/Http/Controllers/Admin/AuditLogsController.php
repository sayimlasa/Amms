<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;
use App\Http\Controllers\Controller;

class AuditLogsController extends Controller
{
    public function index(Request $request)
    {
        // Start building the query
        $query = Audit::with('user')->orderBy('created_at', 'desc'); // Eager load the user relationship

        // Filter by event type if provided
        if ($request->has('event')) {
            $query->where('event', $request->input('event'));
        }

        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->input('start_date'), $request->input('end_date')]);
        }

        // Paginate the results
        $audits = $query->paginate(15);
        return view('admin.audit_logs.index', compact('audits'));
    }
}
