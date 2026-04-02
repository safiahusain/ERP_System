<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Helper\AuthHelper;
use Illuminate\Http\Request;
use App\Helper\NotificationHelper;
use App\Models\Functionality;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public $scope;

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index(Request $request)
    {
        $auth       =   AuthHelper::checkAuth();
        $user       =   $auth->user;
        $message    =   trans('messages.un_authorized');
        $type       =   'info';
        $code       =   401;
        $success    =   false;
        $allowed    =   array_key_exists("ROLE",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            if ($request->ajax())
            {
                $roles  =   Role::paginate(10);

                return view('includes.tables.role.table', compact(
                    'roles',
                    'auth',
                ));
            }
            else
            {
                return view('role.index',compact(
                    'auth',
                ));
            }
        }

        $message    =   trans('messages.un_authorized');
        $type       =   'info';
        $flash      =   NotificationHelper::makeFlashNotification($message,$type);

        return redirect(route('home'))->with($flash->type,$flash);
    }

    public function create(Request $request)
    {
        $auth       =   AuthHelper::checkAuth();
        $message    =   trans('messages.un_authorized');
        $type       =   'info';
        $code       =   401;
        $success    =   false;
        $allowed    =   array_key_exists("ROLECRT",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $rules          =   [
                'name'          =>  ['required', 'string', 'max:255'],
                'tag'           =>  ['required', 'string', 'lowercase', 'max:50', 'regex:/^[a-z0-9\-]+$/', 'unique:roles,tag'],
                'linked_role'   =>  ['required','string',
                                        function ($attribute, $value, $fail)
                                        {
                                            $roleExists = Role::where(['tag'=> $value, "is_system" => true])->exists();

                                            if (!$roleExists)
                                            {
                                                $fail('The selected linked role is invalid. Role tag does not exist.');
                                            }
                                        },
                                    ],
            ];

            $request->validate($rules);

            $created    =   Role::create([
                'name'              =>  $request->name,
                'tag'               =>  $request->tag,
                'linked_role_tag'   =>  $request->linked_role,
            ]);

            $message    =   trans('Something went wrong while creating role');
            $type       =   'error';
            $code       =   500;

            if ($created)
            {
                $message    =   trans('Role created Successfully');
                $type       =   'success';
                $code       =   200;
                $success    =   true;
            }
        }

        return response()->json([
            'success'   =>  $success,
            'type'      =>  $type,
            'message'   =>  $message,
        ],$code);
    }

    public function update(Request $request, $id)
    {
        $auth       =   AuthHelper::checkAuth();
        $message    =   trans('messages.un_authorized');
        $type       =   'info';
        $code       =   401;
        $success    =   false;
        $allowed    =   array_key_exists("ROLEUPD",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $role       =   Role::find($id);
            $message    =   trans('Role not found');
            $type       =   'info';
            $code       =   404;

            if($role)
            {
                $rules          =   [
                    'name'  =>  ['required', 'string', 'max:255'],
                    'tag'   =>  ['required', 'string', 'lowercase', 'max:50', 'regex:/^[a-z0-9\-]+$/', Rule::unique('roles', 'tag')->ignore($role->id)],
                ];

                if(!$role->is_system)
                {
                    $rules  +=   [
                        'linked_role'   =>  ['required','string',
                                                function ($attribute, $value, $fail)
                                                {
                                                    $roleExists = Role::where(['tag'=> $value, "is_system" => true])->exists();

                                                    if (!$roleExists)
                                                    {
                                                        $fail('The selected linked role is invalid. Role tag does not exist.');
                                                    }
                                                },
                                            ],
                    ];
                }

                $request->validate($rules);

                $updated_data   =   [
                    'name'  =>  $request->name,
                ];

                if(!$role->is_system)
                {
                    $updated_data   =   [
                        'tag'               =>  $request->tag,
                        'linked_role_tag'   =>  $request->linked_role,
                    ];
                }
                $updated    =   $role->update($updated_data);

                $message    =   trans('Something went wrong while updating role');
                $type       =   'error';
                $code       =   500;

                if ($updated)
                {
                    $message    =   trans('Role updated Successfully');
                    $type       =   'success';
                    $code       =   200;
                    $success    =   true;
                }
            }
        }

        return response()->json([
            'success'   =>  $success,
            'type'      =>  $type,
            'message'   =>  $message,
        ],$code);
    }

    public function delete(Request $request, $id)
    {
        $auth       =   AuthHelper::checkAuth();
        $message    =   trans('messages.un_authorized');
        $type       =   'info';
        $code       =   401;
        $success    =   false;
        $allowed    =   array_key_exists("ROLEDLT",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $role       =   Role::find($id);
            $message    =   trans('Role not found');
            $type       =   'info';
            $code       =   404;

            if($role)
            {
                $message    =   trans('You don\'t have permission to delete this role');
                $type       =   'info';
                $code       =   401;

                if(!$role->is_system)
                {
                    $deleted    =   $role->delete();
                    $message    =   trans('Something went wrong while deleting role');
                    $type       =   'error';
                    $code       =   500;

                    if ($deleted)
                    {
                        $message    =   trans('Role deleted Successfully');
                        $type       =   'success';
                        $code       =   200;
                        $success    =   true;
                    }
                }
            }
        }

        return response()->json([
            'success'   =>  $success,
            'type'      =>  $type,
            'message'   =>  $message,
        ],$code);
    }

    public function getAction(Request $request, $id)
    {
        $auth       =   AuthHelper::checkAuth();
        $message    =   trans('messages.un_authorized');
        $type       =   'info';
        $code       =   401;
        $allowed    =   array_key_exists("ROLEPRMSION",$auth->func);
        $htm_text   =   "";

        if ($allowed || $auth->role == "super_admin")
        {
            if ($request->ajax())
            {
                $code       =   404;
                $message    =   "Role not found";
                $role       =   Role::find($id);

                if ($role)
                {
                    $functionality  =   Functionality::where(['status' => 1])->get();
                    $message        =   "Permissions not found";

                    if ($functionality)
                    {
                        // Separate menus
                        $menus  =   $functionality->where('target', 'menu');
                        $func   =   $role->functionalities->pluck('tag')->toArray();

                        if ($menus->count())
                        {
                            foreach ($menus as $menu)
                            {
                                $group = preg_replace('/[^a-zA-Z0-9_-]/', '_', strtoupper($menu->tag));
                                $parentChecked = in_array($menu->tag, $func) ? 'checked' : '';

                                $htm_text .= "<div class='permission-group mb-4'>
                                                <div class='form-check mb-2'>
                                                    <input type='checkbox'
                                                        class='form-check-input parent-check action_checkbox'
                                                        data-id='".$menu->id."'
                                                        data-group='".$group."'
                                                        id='parent_".$group."'
                                                        {$parentChecked}>
                                                    <label class='form-check-label font-weight-bold'>
                                                        ".ucfirst($menu->name)."
                                                    </label>
                                                </div>
                                                <div class='row ml-3'>";

                                // Get children actions of this menu
                                $actions = $functionality
                                            ->where('parent_id', $menu->id)
                                            ->where('target', 'action');

                                foreach ($actions as $action)
                                {
                                    $childChecked = in_array($action->tag, $func) ? 'checked' : '';

                                    $htm_text .= "<div class='col-md-3'>
                                                    <div class='form-check'>
                                                        <input type='checkbox'
                                                            data-id='".$action->id."'
                                                            data-parent='".$group."'
                                                            value='".$action->id."'
                                                            class='form-check-input child-check action_checkbox child_".$group."'
                                                            {$childChecked}>
                                                        <label class='form-check-label'>
                                                            ".ucfirst(str_replace('-', ' ', $action->name))."
                                                        </label>
                                                    </div>
                                                </div>";
                                }

                                $htm_text .= "   </div>
                                            </div>";
                            }

                            $code    = 200;
                            $message = "Permissions found";
                        }
                    }
                }
            }
        }

        return response()->json([
            'message'   =>  $message,
            'type'      =>  $type,
            'htm_text'  =>  $htm_text
        ],$code);
    }

    public function updateAction(Request $request,$id)
    {
        $auth       =   AuthHelper::checkAuth();
        $message    =   trans('messages.un_authorized');
        $type       =   'info';
        $code       =   401;
        $allowed    =   array_key_exists("ROLEPRMSION",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $role       =   Role::find($id);
            $message    =   "Role not found";
            $code       =   404;

            if ($role)
            {
                $message    =   trans('messages.something_went_wrong');
                $type       =   'info';
                $code       =   423;
                $action_ids =   $request->action_ids    ??  [];

                if ($action_ids && !is_array($action_ids))
                {
                    $action_ids = explode(',', $action_ids);
                }

                $updated        =   $role->functionalities()->sync($action_ids);

                if ($updated)
                {
                    $message    =   trans('Actions Updated Successfully');
                    $type       =   'success';
                    $code       =   200;
                }
            }
        }

        return response()->json([
            'message'   =>  $message,
            'type'      =>  $type
        ],$code);
    }
}
