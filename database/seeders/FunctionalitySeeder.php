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

        if (!$func) return;

        $parentMap = []; // yahan parent name => id store hoga

        /**
         * STEP 1: Insert Parents (jinki parent_id null hai)
         */
        foreach ($func as $key => $value)
        {
            if ($value['parent_id'] === null)
            {
                $existingFunc = functionality::where('tag', $value['tag'])->first();

                if (!$existingFunc)
                {
                    $created = functionality::create([
                        'name'      => $key,
                        'tag'       => $value['tag'],
                        'target'    => $value['target'],
                        'status'    => $value['status'],
                        'parent_id' => null,
                        'order'     => $value['order'] ?? 0,
                        'data'      => json_encode($value['data']),
                    ]);

                    $parentMap[$key] = $created->id;
                }
                else
                {
                    $parentMap[$key] = $existingFunc->id;
                }
            }
        }

        /**
         * STEP 2: Insert Children
         */
        foreach ($func as $key => $value)
        {
            if ($value['parent_id'] !== null)
            {
                // "user_id" → "user"
                $parentKey = str_replace('_id', '', $value['parent_id']);

                $parentId = $parentMap[$parentKey] ?? null;

                if (!$parentId) continue; // safety

                $existingFunc = functionality::where('tag', $value['tag'])->first();

                if (!$existingFunc)
                {
                    functionality::create([
                        'name'      => $key,
                        'tag'       => $value['tag'],
                        'target'    => $value['target'],
                        'status'    => $value['status'],
                        'parent_id' => $parentId, // 🔥 actual ID
                        'order'     => $value['order'] ?? 0,
                        'data'      => json_encode($value['data']),
                    ]);
                }
            }
        }
    }
}
