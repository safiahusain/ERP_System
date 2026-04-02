<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        foreach (config('defaults.roles') as $key => $value)
        {
            $found  =   Role::where([
                'tag'      =>  $key,
            ])->first();

            if (!$found)
            {
                Role::create([
                    'name'      =>  $value,
                    'tag'       =>  $key,
                    'is_system' =>  1,
                ]);
            }
        }
    }
}
