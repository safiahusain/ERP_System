<?php

namespace App\Http\Controllers;

use App\Helper\AuthHelper;
use App\Helper\NotificationHelper;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $auth    =   AuthHelper::checkAuth();
        $user    =   $auth->user;
        $allowed =   array_key_exists("USER",$auth->func);

        if($allowed || $auth->role == "super_admin")
        {
            if ($request->ajax())
            {
                $users = User::latest()->paginate(10);

                return view('includes.tables.user.table', compact(
                    'users',
                    'auth',
                ));
            }
            else
            {
                $roles      =   Role::select('name', 'tag')->get()->toArray();

                return view('user.index',compact(
                    'roles',
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
        $auth           =   AuthHelper::checkAuth();
        $user           =   $auth->user;
        $message        =   trans('messages.un_authorized');
        $type           =   'info';
        $code           =   401;
        $success        =   false;
        $allowed        =   array_key_exists("USERCRT",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $rules          =   [
                'name'          =>  ['required', 'string', 'max:255'],
                'email'         =>  ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password'      =>  ['required', 'string'],
                'contact'       =>  ['required', 'regex:/^[0-9\-\+]+$/'],
                'address'       =>  ['required', 'max:255'],
                'role'          =>  ['required'],
            ];

            if($request->role == "4")
            {
                $rules  +=   [
                    'company_name'      =>  ['required', 'string', 'max:255'],
                    'company_contact'   =>  ['required', 'regex:/^[0-9\-\+]+$/'],
                    'company_address'   =>  ['required', 'max:255'],
                ];
            }

            $request->validate($rules);

            $password       =   Hash::make($request->password);
            $user_create    =   [
                'name'      =>  $request->name,
                'email'     =>  $request->email,
                'password'  =>  $password,
                'phone'     =>  $request->contact,
                'address'   =>  $request->address,
                'role_tag'  =>  $request->role,
            ];

            if($request->role == "client")
            {
                $user_create    +=  [
                    'company_name'      =>  $request->company_name,
                    'company_contact'   =>  $request->company_contact,
                    'company_address'   =>  $request->company_address,
                ];
            }

            $created    =   User::create($user_create);

            $message    =   trans('Something went wrong while creating user');
            $type       =   'error';
            $code       =   500;

            if ($created)
            {
                $message    =   trans('User created Successfully');
                $type       =   'success';
                $code       =   202;
                $success    =   true;
            }
        }

        return response()->json([
            'success'   =>  $success,
            'type'      =>  $type,
            'message'   =>  $message,
        ],$code);
    }

    public function showUserAssign(Request $request, $id)
    {
        $auth       =   AuthHelper::checkAuth();
        $message    =   trans('messages.un_authorized');
        $type       =   'info';
        $code       =   401;
        $allowed    =   array_key_exists("USERSHOWTMLEAD",$auth->func);
        $htm_text   =   "";

        if ($allowed || $auth->role == "super_admin")
        {
            if ($request->ajax())
            {
                $code       =   404;
                $message    =   "User not found";
                $user       =   User::find($id);

                if ($user)
                {
                    $message    =   "Selected user role is not eligible for this assignment.";
                    $code       =   401;

                    if($user->isTeamMemberType() || $user->isManagerType())
                    {
                        $relatedUsers   =   $user->isTeamMemberType()
                                            ?   $user->managers()->select('id', 'email')->get()->toArray()
                                            :   $user->TeamMem()->select('id', 'email')->get()->toArray();
                        $message        =   "Permissions not found";

                        if ($relatedUsers)
                        {
                            $assignUsers    =    $user->isTeamMemberType()
                                                ?   ($user->TeamManagers ? $user->TeamManagers->pluck('id')->toArray() : [])
                                                :   ($user->teamMembers ? $user->teamMembers->pluck('id')->toArray() : []);

                            foreach ($relatedUsers as $r_user)
                            {
                                $isChecked =    in_array($r_user['id'], $assignUsers) ? 'checked' : '';
                                $htm_text .=    "<div class='col-md-4'>
                                                    <div class='form-check d-flex align-items-center gap-2'>
                                                        <input
                                                            type='checkbox'
                                                            class='user_checkbox'
                                                            onchange='get_role_ids(this,{$r_user['id']})'
                                                            data-id='{$r_user['id']}'
                                                            name='user-{$r_user['id']}'
                                                            {$isChecked}
                                                            data-bootstrap-switch
                                                            data-off-color='danger'
                                                            data-on-color='success'>

                                                        <label class='form-check-label mb-0'>
                                                            ".ucfirst(str_replace('-', ' ', $r_user['email']))."
                                                        </label>
                                                    </div>
                                                </div>";
                            }

                            $htm_text .= "   </div>
                                        </div>";

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

    public function storeUserAssign(Request $request, $id)
    {
        $auth       =   AuthHelper::checkAuth();
        $message    =   trans('messages.un_authorized');
        $type       =   'info';
        $code       =   401;
        $allowed    =   array_key_exists("USERASTMLEAD",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $role       =   User::find($id);
            $message    =   "User not found";
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
