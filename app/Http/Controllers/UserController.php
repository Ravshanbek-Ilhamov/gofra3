<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\Role;
use App\Models\RoleUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users=User::orderBy('id','desc')->where('name','!=','admin')->paginate(10);
        $roles=Role::all();
        return view('Users.index',['users'=>$users,'roles'=>$roles]);
    }
    public function create(UserCreateRequest $request)
    {
       // dd($request->all());
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        RoleUsers::create([
            'role_id'=>$validated['role_id'],
            'user_id'=>$user->id
        ]);
        return redirect()->back()->with('success', 'User created successfully');
    }
    public function update(UserUpdateRequest $request,User $user)
    {
        $validated = $request->validated();

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();
    
        RoleUsers::updateOrCreate(
            ['user_id' => $user->id],
            ['role_id' => $validated['role_id']]
        );
    
        return redirect()->back()->with('success', 'User updated successfully');
    }
    public function delete(User $user)
    {
        // dd($user->name);
        $user->delete();
        return redirect()->back()->with('success','User deleted successfully');
    }
}
