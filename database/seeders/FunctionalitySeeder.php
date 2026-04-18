<?php

namespace Database\Seeders;

use App\Models\functionality;
use Illuminate\Database\Seeder;

class FunctionalitySeeder extends Seeder
{
    public function run()
    {
        $func = config('rolesFunc.functionalities');

        if (!$func) return;

        $parentMap = [];

        /**
         * STEP 1: Insert ROOT MENUS (parent_id = null)
         */
        foreach ($func as $key => $value)
        {
            if ($value['parent_id'] === null)
            {
                $existing = functionality::where('tag', $value['tag'])->first();

                if (!$existing)
                {
                    $created = functionality::create([
                        'name'      => $key,
                        'tag'       => $value['tag'],
                        'target'    => $value['target'],
                        'status'    => $value['status'],
                        'parent_id' => null,
                        'order'     => $value['order'] ?? 0,
                        'data'      => json_encode($value['data'] ?? []),
                    ]);

                    $parentMap[$key] = $created->id;
                }
                else
                {
                    $existing->update([
                        'name'   => $key,
                        'target' => $value['target'],
                        'status' => $value['status'],
                        'order'  => $value['order'] ?? 0,
                        'data'   => json_encode($value['data'] ?? []),
                    ]);

                    $parentMap[$key] = $existing->id;
                }
            }
        }

        /**
         * STEP 2: HANDLE ALL LEVELS (menus + submenus + actions)
         */
        $pending = true;

        while ($pending)
        {
            $pending = false;

            foreach ($func as $key => $value)
            {
                // skip if already inserted
                if (isset($parentMap[$key])) continue;

                if ($value['parent_id'] !== null)
                {
                    $parentKey = str_replace('_id', '', $value['parent_id']);

                    // agar parent abhi tak insert nahi hua → skip
                    if (!isset($parentMap[$parentKey])) continue;

                    $parentId = $parentMap[$parentKey];

                    $existing = functionality::where('tag', $value['tag'])->first();

                    if (!$existing)
                    {
                        $created = functionality::create([
                            'name'      => $key,
                            'tag'       => $value['tag'],
                            'target'    => $value['target'],
                            'status'    => $value['status'],
                            'parent_id' => $parentId,
                            'order'     => $value['order'] ?? 0,
                            'data'      => json_encode($value['data'] ?? []),
                        ]);

                        $parentMap[$key] = $created->id;
                        $pending = true;
                    }
                    else
                    {
                        $existing->update([
                            'name'      => $key,
                            'target'    => $value['target'],
                            'status'    => $value['status'],
                            'parent_id' => $parentId,
                            'order'     => $value['order'] ?? 0,
                            'data'      => json_encode($value['data'] ?? []),
                        ]);

                        $parentMap[$key] = $existing->id;
                        $pending = true;
                    }
                }
            }
        }

        /**
         * OPTIONAL: DEBUG (agar koi entry insert nahi hui)
         */
        foreach ($func as $key => $value)
        {
            if (!isset($parentMap[$key]))
            {
                \Log::warning("Functionality not inserted: " . $key);
            }
        }
    }
}
