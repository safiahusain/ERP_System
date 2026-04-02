<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $role  = Role::where('name', 'super_admin')->first();

        if (!$role)
        {
            $role = Role::create([
                'tag' => 'super_admin',
            ]);
        }

        $user  =   User::where('role_tag', $role->tag)->first();

        if (!$user)
        {
            User::create([
                'name'      =>  'Super Admin',
                'email'     =>  'superadmin@promanage.com',
                'password'  =>  Hash::make('admin123'),
                'role_tag'  =>  $role->tag,
            ]);
        }
    }
}
