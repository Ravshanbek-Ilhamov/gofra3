<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\PermissionUpdateRequest;
use App\Models\Permit;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions=Permit::orderBy('id','desc')->paginate(10);
        return view('Permission.index',['permissions'=>$permissions]);
    }
    public function update(Permit $permission)
    {
       // dd($permission->name);
       if($permission->status)
       {
        $permission->status=0;
       }
       else
       {
        $permission->status=1;
       }
       $permission->save();
       return redirect()->back()->with('success','Permission status changed updated successfully');

    }
    public function edit(PermissionUpdateRequest $request,Permit $permission)
    {
       // dd($request->all());
       $validated=$request->validated();
       $permission->name=$validated['name'];
       $permission->save();
       return redirect()->back()->with('success','Permission name updated successfully');
    }
}
