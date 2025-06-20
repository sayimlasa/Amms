<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Campus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function index()
    {
    abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    $users=User::get();
    $roles=Role::get();
    return view('admin.users.index',compact('users','roles'));
    }
    public function indexapi(){
        
    }
    public function list(Request $request)
    {
        // Fetch all users from the database
        $users = User::all();
        // Return the users in the response
        return response()->json($users);
    }
    public function createUser(Request $request)
    {
      // Validate the incoming data
      $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'campus_id'=>'required|integer',
        'mobile'=>'required|min:10',
        'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'campus_id'=>1,
            'mobile'=>$request->mobile,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully.'], 200);
    }
    
        // Edit a user
        public function editUser(Request $request, $id)
        {
            // Validate the incoming data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'mobile' => 'required|string|max:15',
                'campus_id' => 'required|exists:campuses,id',
                'email' => 'required|email|max:255|unique:users,email,' . $id,
                'active' => 'required|boolean',
            ]);
    
            // If validation fails, return errors
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors(), ], 422);
            }
            // Find the user by ID
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }
            // Update the user details
            $user->name = $request->name;
            $user->mobile = $request->mobile;
            $user->campus_id = $request->campus_id;
            $user->email = $request->email;
            $user->active = $request->active;    
            // Save the changes
            $user->save();
              // Sync roles with the user (attach roles)
        if ($request->has('roles')) {
            $user->roles()->sync($request->roles); // This will attach or detach roles as necessary
        }

        return response()->json([
            'message' => 'User updated successfully!',
            'user' => $user,
            'roles' => $user->roles, // Optionally return updated roles
        ], 200);
    
        }      
    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::pluck('title', 'id');
        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $hashedPassword = Hash::make($request->password);
        $user = User::create($request->except(['role_id']));
        $user->roles()->attach($request->role_id);
        //$user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');
        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
{
    // Update user data except 'role_id'
    $user->update($request->except(['role_id']));

    // Get the roles from the request
    $roleIds = $request->role_id;
    // Loop through the role ids
    foreach ($roleIds as $roleId) {
        // Check if the role-user combination already exists
        if (!$user->roles()->where('role_id', $roleId)->exists()) {
            // Attach the role if it doesn't exist
            $user->roles()->attach($roleId);
        }
    }
    return redirect()->route('admin.users.index');
}
    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //$user->load('campus', 'roles', 'userStaffProfiles', 'facilitatorCaResults', 'userUserAlerts');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }
}
