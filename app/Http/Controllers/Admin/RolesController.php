<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Campus;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get(); // Fetch all roles and their permissions
        return view('admin.roles.index', compact('roles')); // Pass roles to the view
    }

    // Show the form for creating a new role
    public function create()
    {
        // Get all permissions
        $permissions = Permission::all();

        return view('admin.roles.create', compact('permissions'));
    }

    //create role by using api
    public function storeApi(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:roles',
            'permissions' => 'array', // Optional, can be empty
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['title' => $request->title]);
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return response()->json(['message' => 'Role created successfully', 'role' => $role], 201);
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->except(['permission_id']));
        $role->permissions()->attach($request->permissions);
        return redirect()->route('admin.roles.index');
    }
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id); // Fetch role with permissions
        $permissions = Permission::all(); // Fetch all permissions
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['title' => $request->title]);
        $role->permissions()->sync($request->permissions);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully!');
    }

    public function show(Role $role)
    {
        abort_if(Gate::denies('role_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //$role->load('permissions', 'roleStudentsProfiles');

        return view('admin.roles.show', compact('role'));
    }
    //show role and permission
    // Show a single role with its permissions
    public function showApi($id)
    {
        $role = Role::with('permissions')->find($id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        return response()->json(['role' => $role], 200);
    }
    // Update a role
    public function updateApi(Request $request, $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $request->validate([
            'title' => 'required|string|unique:roles,title,' . $id,
            'permissions' => 'array', // Optional
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['title' => $request->title]);

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return response()->json(['message' => 'Role updated successfully', 'role' => $role], 200);
    }

    // Delete a role
    public function destroy($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $role->permissions()->detach(); // Detach permissions before deleting
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully!');
    }
}
