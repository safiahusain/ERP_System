<?php

namespace Database\Seeders;

use App\Models\functionality;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FunctionalitySeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $func  = config('defaults.functionalities');

        if ($func)
        {
            foreach ($func as $key => $value)
            {
                $existingFunc = functionality::where('tag', $value['tag'])->first();

                if (!$existingFunc)
                {
                    functionality::create([
                        'name'      =>  $key,
                        'tag'       =>  $value['tag'],
                        'target'    =>  $value['target'],
                        'status'    =>  $value['status'],
                        'parent_id' =>  $value['parent_id'] ?? null,
                        'order'     =>  $value['order'] ?? 0,
                        'data'      =>  json_encode($value['data']),
                    ]);
                }
            }
        }
    }
}
