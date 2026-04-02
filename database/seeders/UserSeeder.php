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
        $role  = Role::where('name', 'Admin')->first();

        if (!$role)
        {
            $role = Role::create([
                'name' => 'Admin',
            ]);
        }

        $user  =   User::where('role_id', $role->id)->first();

        if (!$user)
        {
            User::create([
                'name'      =>  'Admin',
                'email'     =>  'admin@promanage.com',
                'password'  =>  Hash::make('admin123'),
                'role_id'   =>  $role->id,
            ]);
        }
    }
}
