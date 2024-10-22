<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:role-list|role-show|role-create|role-edit|role-delete', ['only' => ['index']]);
         $this->middleware('permission:role-show', ['only' => ['show']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request): View
    {
        // Use get() instead of all() to retrieve a collection with query options
        $roles = Role::orderBy('id', 'DESC')->get();
        
        return view('roles.index', compact('roles'));
    }
    
    public function create(): View
    {
        $permission = Permission::get();
        return view('roles.create',compact('permission'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
    
        // Convert permission input to integer array
        $permissionsID = array_map(
            function($value) { return (int)$value; },
            $request->input('permission')
        );
        
        // Create a new role with the validated name
        $role = Role::create(['name' => $request->input('name')]);
        
        // Sync permissions with the newly created role
        $role->syncPermissions($permissionsID);
        
        // Redirect back with a success message
        return redirect()->route('roles.index')
                         ->with('success', 'تم إنشاء الدور بنجاح!');
    }

    public function show($id): View
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
    
        return view('roles.show',compact('role','rolePermissions'));
    }

    public function edit($id): View
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    
        return view('roles.edit',compact('role','permission','rolePermissions'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'permission' => 'required',
        ]);
        
        // Find the role by its ID
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        // Convert permission input to integer array
        $permissionsID = array_map(
            function($value) { return (int)$value; },
            $request->input('permission')
        );
        
        // Sync permissions with the updated role
        $role->syncPermissions($permissionsID);
        
        // Redirect back with a success message
        return redirect()->route('roles.index')
                        ->with('success', 'تم تحديث الدور بنجاح!');
    }


    public function destroy($id): RedirectResponse
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','تم حذف الدور بنجاح!');
    }
}
