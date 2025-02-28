<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roles\RoleCreateRequest;
use App\Http\Requests\Roles\RoleUpdateRequest;
use App\Models\PermissionGroup;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        //dd(123);
        $permissionGroups=PermissionGroup::all();
        $roles = Role::orderby('id', 'desc')->paginate(10);
        return view('Roles.index', ['roles' => $roles,'permissionGroups'=>$permissionGroups]);
    }
    public function create(RoleCreateRequest $request)
    {
       // dd($request->all());
        $validated = $request->validated();

        $role = new Role();
        $role->name = $validated['name'];
        $role->save();

        if (!empty($validated['permissions'])) {
            $role->permissions()->attach($validated['permissions']);
        }

        return redirect('/role')->with('success', 'Role created successfully');
    }
    public function update(RoleUpdateRequest $request, Role $role)
    {
        //dd($request->all());
        $validated = $request->validated();
        $role->name = $validated['name'];
        $role->status = $request->has('status') ? 1 : 0;
        $role->save();
        
        if (!empty($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        } else {
            $role->permissions()->sync([]);
        }
        
        return redirect()->route('role.index')->with('success', 'Role updated successfully');
    }
    public function delete(Role $role)
    {
        $role->delete();
        return redirect()->back()->with('success', 'Role deleted successfully');
    }
    public function page()
    {
        $permissionGroups = PermissionGroup::all();
        return view('Roles.create', ['permissionGroups' => $permissionGroups]);
    }
    public function updatepage(Role $role)
    {
        $permissionGroups = PermissionGroup::all();
        return view('Roles.update', ['permissionGroups' => $permissionGroups,'role'=>$role]);
        //dd($role->name);
    }
    public function updatestatus(Role $role)
    {
        dd(123);
    }
}
