<?php

namespace App\Http\Middleware;

use App\Models\Permit;
use App\Models\Role;
use App\Models\RoleUsers;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Check
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $roleUser = RoleUsers::where('user_id', $user->id)->first();

        if (!$roleUser) {
            abort(403, 'No role assigned');
        }

        $role = Role::find($roleUser->role_id);

        if (!$role) {
            abort(403, 'Invalid role');
        }

        $route = $request->route();
        $permission = Permit::where('path', $route->getName())->first();

        if (!$permission || $permission->status !== 1) {
            abort(403,'You are not permetted to enter this page');
        }
        // dd($role->name);
        if(!$role->status)
        {
            abort(403,'Role status is not active');
        }
        if (!$role->permissions->contains($permission)) {
            abort(403,'Permission not found');
        }

        return $next($request);
        
    }
}
