<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use App\Models\PermissionGroup;
use App\Models\Permit;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\RoleUsers;
use App\Models\User;

class GeneratePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate permissions from route prefixes and names';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $routes = Route::getRoutes();
        $createdPermissions = 0;

        foreach ($routes as $route) {
            if ($route->getPrefix()) {
                $prefix = ltrim($route->getPrefix(), '/');
                $name = $route->getName();

                if ($name) {
                    $group = PermissionGroup::firstOrCreate([
                        'name' => $prefix
                    ]);

                    $permission = Permit::firstOrCreate([
                        'name' => $name,
                        'path' => $name,
                        'group_id' => $group->id
                    ]);

                    if ($permission->wasRecentlyCreated) {
                        $this->info("Permission '{$name}' in group '{$prefix}' created.");
                        $createdPermissions++;
                    } else {
                        $this->info("Permission '{$name}' already exists in group '{$prefix}'.");
                    }
                }
            }
        }

        if ($createdPermissions === 0) {
            $this->info('No new permissions created.');
        } else {
            $this->info("{$createdPermissions} permissions created successfully.");
        }




        $admin = User::where('email', 'admin@gmail.com')->first();

        $role = Role::updateOrCreate([
            'name' => 'admin'
        ]);

        if ($admin) {
            $adminRole = Role::where('name', 'admin')->first();

            if ($adminRole) {
                RoleUsers::updateOrCreate(
                    [
                        'user_id' => $admin->id,
                        'role_id' => $adminRole->id
                    ]
                );

                $permissions = Permit::all();
                foreach ($permissions as $permission) {
                    RolePermission::updateOrCreate(
                        [
                            'role_id' => $adminRole->id,
                            'permission_id' => $permission->id
                        ],
                        [
                            'role_id' => $adminRole->id,
                            'permission_id' => $permission->id
                        ]
                    );
                }

                $this->info('All permissions have been attached to the admin role.');

                RoleUsers::updateOrCreate([
                    'user_id' => $admin->id,
                    'role_id' => $adminRole->id
                ]);
            } else {
                $this->error('Admin role not found.');
            }
        } else {
            $this->error('Admin user not found.');
        }
    }
}
