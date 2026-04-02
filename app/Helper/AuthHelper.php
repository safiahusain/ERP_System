<?php

namespace App\Helper;

use stdClass;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\functionality;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthHelper
{
    public static function checkAuth($user = null)
    {
        $data   =   new stdClass();
        $user   =   $user ? $user : Auth::user();

        if ($user)
        {
            $data->user =   $user;
            $data->role =   $user->roles['name'];
            $func       =   $user->roles->functionalities()->where(['status' => 1])->get();
            // $func       =   $user->roles['slug'] = "admin"
            //                 ?   functionality::where(['target'=> 'action', 'status' => 1])->get()
            //                 :   $user->roles->functionalities()->where(['target'=> 'action', 'status' => 1])->get();

            $data->func     =   $func
                                ->mapWithKeys(function ($item)
                                {
                                    $data =   json_decode($item->data) ?? [];

                                    $data = [
                                        'id'     => $item->id,
                                        'name'   => $item->name,
                                        'target' => $item->target,
                                    ];

                                    return [
                                        $item->tag => $data
                                    ];
                                })
                                ->toArray();
        }

        return $data;
    }

    public static function createMenu()
    {
        $data   = new \stdClass();
        $user   = Auth::user();

        if ($user)
        {
            $data->user = $user;

            // $menu       =   in_array($user->roles['name'], ["Admin", "admin"])
            //                 ?   Functionality::where('target', 'menu')
            //                     ->whereNull('parent_id')
            //                     ->where('status', 1)
            //                     ->with('children')
            //                     ->orderBy('order')
            //                     ->get()
            //                 :   $user->roles->functionalities()
            //                     ->where('target', 'menu')
            //                     ->whereNull('parent_id')
            //                     ->where('status', 1)
            //                     ->with('children')
            //                     ->orderBy('order')
            //                     ->get();
            $menu       =   $user->roles->functionalities()
                                ->where('target', 'menu')
                                ->whereNull('parent_id')
                                ->where('status', 1)
                                ->with('children')
                                ->orderBy('order')
                                ->get();

            $data->menu =   $menu->mapWithKeys(function ($item)
                            {
                                return [
                                    $item->tag => self::buildMenuTree($item)
                                ];
                            })->toArray();
        }

        return $data;
    }

    private static function buildMenuTree($item)
    {
        $data   =   json_decode($item->data) ?? new \stdClass();

        $result =   [
                        'id'    => $item->id,
                        'name'  => $item->name,
                        'tag'   => $item->tag,
                        'route' => $data->route ?? null,
                        'icon'  => $data->icon ?? null,
                    ];

        if ($item->children && $item->children->count())
        {
            $result['children'] =   $item->children
                                    ->sortBy('order')
                                    ->map(function ($child)
                                    {
                                        return self::buildMenuTree($child);
                                    })->values()->toArray();
        }

        return $result;
    }
}
