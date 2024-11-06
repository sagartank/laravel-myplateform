<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Permission;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role_master|add-role|edit-role|delete-role', ['only' => ['index','show']]);
        $this->middleware('permission:add-role', ['only' => ['create','store']]);
        $this->middleware('permission:edit-role', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth()->user();
        return view('admin.roles.index', ['roles' => Role::where('is_for_user_level',0)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::whereNull('parent_id')
                    ->where('is_for_user',0)
                    ->with('childrenPermissions')
                    ->get();
        return view('admin.roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,display_name'],
            'description' => ['nullable', 'string'],
        ]);

        $role = Role::create([
            'display_name' => $request->input('name'),
            'name' => strtolower(str_replace(' ', '-', $request->input('name'))),
            'description' => $request->input('description'),
        ]);
        if($request->input('permissions') && count($request->input('permissions')) > 0){
            $role->attachPermissions($request->input('permissions') ?? []);
        }
        
        return redirect()->route('admin.roles.edit', $role)->with('success', 'Role added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $roleAssignPermission = $role->permissions()->get()->pluck('id')->toArray();
        $permissions = Permission::whereNull('parent_id')
                ->where('is_for_user',0)
                ->with('childrenPermissions')
                ->get();
        return view('admin.roles.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'roleAssignPermission' => $roleAssignPermission,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'display_name')->ignore($role)],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
            'permissions' => ['sometimes', 'nullable', 'array'],
            'permissions.*' => ['required', 'numeric', 'integer'],
        ]);

        $role->display_name = $request->input('name');
        $role->name = strtolower(str_replace(' ', '-', $request->input('name')));
        $role->description = $request->input('description');
        $role->is_active = $request->has('is_active') ? 1 : 0;
        $role->save();

        if($request->input('permissions') && count($request->input('permissions')) > 0){
            $role->syncPermissions($request->input('permissions') ?? []);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully!');
    }
}
