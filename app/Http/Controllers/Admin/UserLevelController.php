<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserLevel;
use App\Models\Permission;
use App\Models\Role;

class UserLevelController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user_level_master|add-user-level|edit-user-level|delete-user-level', ['only' => ['index','show']]);
        $this->middleware('permission:add-user-level', ['only' => ['create','store']]);
        $this->middleware('permission:edit-user-level', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-user-level', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_levels = UserLevel::orderBy('id', 'asc')->get();
        return view('admin.user-level.index', ['user_levels' => $user_levels]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::whereNull('parent_id')
                    ->where('is_for_user',1)
                    ->with('childrenPermissions')
                    ->get();
        return view('admin.user-level.create',compact('permissions'));
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
            'name' => ['required', 'string', 'max:255', 'unique:user_level,name'],
            'number_of_deals' => ['required', 'numeric', 'integer'],
            'amount_of_sales_pyg' => ['required', 'numeric', 'integer'],
            'can_view_upto_amount_pyg' => ['required', 'numeric', 'integer'],
            //'permissions.*' => ['required', 'integer'],
        ]);
        $create = UserLevel::create([
            'name' => $request->name,
            'number_of_deals' => $request->number_of_deals,
            'amount_of_sales_pyg' => $request->amount_of_sales_pyg,
            'can_view_upto_amount_pyg' => $request->can_view_upto_amount_pyg,
        ]);
        //Create role along with this user level to syn permission with this user level
        $role = Role::create([
            'display_name' => $create->name,
            'name' => strtolower(str_replace(' ', '-', $create->name)),
            'is_for_user_level' => 1,
        ]);
        if($request->input('permissions') && count($request->input('permissions')) > 0){
            $role->attachPermissions($request->input('permissions') ?? []);
        }
        return redirect()->route('admin.user-level.index')->with('success', 'User Level added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(UserLevel $user_level)
    {
        $permissions = Permission::whereNull('parent_id')
                ->where('is_for_user',1)
                ->with('childrenPermissions')
                ->get();

        $role = Role::where('name',$user_level->name)->first();
        $roleAssignPermission = ($role) ? $role->permissions()->get()->pluck('id')->toArray() : [];
        return view('admin.user-level.edit', ['edit' => $user_level, 'permissions' => $permissions,'roleAssignPermission' => $roleAssignPermission]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserLevel $user_level)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:user_level,name,'.$user_level->id],
            'number_of_deals' => ['required', 'numeric', 'integer'],
            'amount_of_sales_pyg' => ['required', 'numeric', 'integer'],
            'can_view_upto_amount_pyg' => ['required', 'numeric', 'integer'],
        ]);

        $update_req = $request->except(['_token', '_method','permissions']);
        $update = UserLevel::where('slug', $user_level->slug)->update($update_req );

        // Update role & permission when update user level
        $role = Role::where('name',$user_level->name)->first();

        if($request->input('permissions') && count($request->input('permissions')) > 0){
            $role->syncPermissions($request->input('permissions') ?? []);
        }

        return redirect()->route('admin.user-level.index')->with('success', 'User Level Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, UserLevel $user_level)
    {
        $role = Role::where('name',$user_level->name)->first();
        $role->delete();

        $user_level->delete();
        
        return redirect()->route('admin.user-level.index')->with('success', 'User Level deleted successfully!');
    }

    public function forceDelete(Request $request, $slug)
    {
        if($request->ajax())
        {
            $result = UserLevel::where('slug', $slug)->first();

            if($result)
            {
                //Delete role also when deleteing this user level
                $role = Role::where('name',$result->name)->first();
                $role->delete();

                $result->forceDelete();
                $response = [
                    'status' => true,
                    'message' => 'User Level deleted successfully',
                    'data' => ''
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'something went wrong please try again!',
                    'data' => ''
                ];
            }
            return response()->json($response);
        } else {
            abort(404, 'File not found!');
        }
    }
}
