<?php

namespace App\Http\Controllers;

use App\Helper\AuthHelper;
use App\Helper\NotificationHelper;
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
        $allowed =   in_array("USER",$auth->menu);

        if($allowed)
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
                return view('user.index',compact(
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
        $allowed        =   in_array("USER",$auth->menu);

        if ($allowed)
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
                'name'                  =>  $request->name,
                'email'                 =>  $request->email,
                'password'              =>  $password,
                'contact'               =>  $request->contact,
                'address'               =>  $request->address,
                'role_id'               =>  $request->role,
            ];

            if($request->role == "4")
            {
                $user_create    +=  [
                    'company_name'          =>  $request->company_name,
                    'company_contact'       =>  $request->company_contact,
                    'company_address'       =>  $request->company_address,
                ];
            }
            dd($request->all(),$user_create);

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
}
