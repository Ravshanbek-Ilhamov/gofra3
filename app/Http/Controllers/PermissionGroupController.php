<?php

namespace App\Http\Controllers;

use App\Models\PermissionGroup;
use Illuminate\Http\Request;

class PermissionGroupController extends Controller
{
    public function index()
    {
        $permissionGroups=PermissionGroup::orderBy('id','desc')->paginate(10);
        return view('PermissionGroup.index',['permissionGroups'=>$permissionGroups]);
    }
    public function update(PermissionGroup $group)
    {
        //dd($group->name);
        if($group->status)
        {
            $group->status=0;
        }else{
            $group->status=1;
        }
        $group->save();
        $permissions = $group->permissions;

    foreach ($permissions as $permission) {
        // Agar group active bo'lsa, permission'ni active qiling
        if ($group->status == 1) {
            $permission->status = 1; // Active
        } else {
            $permission->status = 0; // Inactive
        }
        $permission->save();
    }
        return redirect()->back()->with('success','Status changed successfully');
    }
}
