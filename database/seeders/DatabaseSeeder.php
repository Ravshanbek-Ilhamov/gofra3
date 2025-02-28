<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Machine;
use App\Models\Product;
use App\Models\Role;
use App\Models\RoleUsers;
use App\Models\SalaryType;
use App\Models\User;
use App\Models\UserOrder;
use App\Models\Warehouse;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
        ]);
        $user=User::create([
            'name'=>'Muhammadnabi',
            'email'=>'xoliqulovmuhammadnabi842@gmail.com',
            'password'=>'password'
        ]);
        $role=Role::create([
            'name'=>'user'
        ]);
        Role::create([
            'name'=>'machine'
        ]);
        RoleUsers::create([
            'role_id'=>$role->id,
            'user_id'=>$user->id
        ]);
        Department::create([
            'name'=>'Hr'
        ]);
       SalaryType::create([
        'name'=>'full_time'
       ]);
        Warehouse::create([
            'name'=>'Warehouse1',
            'user_id'=>$user->id
        ]);
        Machine::create([
            'name'=>"Machine1"
        ]);
        

    }
}
