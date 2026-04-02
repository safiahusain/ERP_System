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
                'slug'      =>  $key,
            ])->first();

            if (!$found)
            {
                Role::create([
                    'name'      =>  $value,
                    'slug'      =>  $key,
                    'is_system' =>  1,
                ]);
            }
        }
    }
}
