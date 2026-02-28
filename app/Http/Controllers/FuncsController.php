<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Helper\Helper;
use App\Models\Activity;
use App\Helper\AuthHelper;
use Illuminate\Http\Request;
use App\Models\Functionality;
use Illuminate\Validation\Rule;
use App\Helper\NotificationHelper;
use Illuminate\Support\Facades\Auth;

class FuncsController extends Controller
{
    public $scope;

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);

        $this->scope  =   config('defaults.scope');
    }

    public function index(Request $request)
    {
        $auth           =   AuthHelper::checkAuth();
        $user           =   $auth->user;
        $isSuperAdmin   =   $auth->isSuperAdmin;
        $isDevSupport   =   $auth->isDevSupport;
        $allowed        =   AuthHelper::checkFunc($auth->funcs['menu'],["STGUSRFNC"]);

        if ($allowed)
        {
            if ($isSuperAdmin || $isDevSupport)
            {
                if ($request->ajax())
                {
                    $funcs  =   Functionality::where(['target' => 'menu'])->paginate(20);

                    return view('includes.tables.functionalities.table', compact(
                        'isSuperAdmin',
                        'isDevSupport',
                        'funcs',
                        'auth',
                    ));
                }
                else
                {
                    return view('functionalites.index',compact(
                        'isSuperAdmin',
                        'auth',
                    ));
                }
            }
        }

        $message    =   trans('messages.un_authorized');
        $type       =   'info';
        $flash      =   NotificationHelper::makeFlashNotification($message,$type);

        return redirect(route('home'))->with($flash->type,$flash);
    }

    public function getRoles(Request $request,Functionality $functionality)
    {
        $auth           =   AuthHelper::checkAuth();
        $user           =   $auth->user;
        $isSuperAdmin   =   $auth->isSuperAdmin;
        $isDevSupport   =   $auth->isDevSupport;
        $code           =   401;

        if ($isSuperAdmin || $isDevSupport)
        {
            if ($request->ajax())
            {
                $code       =   404;
                $message    =   "Role not found";

                if ($functionality)
                {
                    $roles       =   $functionality->roles;

                    return view('includes.tables.functionalities.roles', compact(
                        'roles',
                    ));
                }
            }
        }

        $message    =   trans('messages.un_authorized');
        $type       =   'info';

        return response()->json([
            'message'   =>  $message,
            'type'      =>  $type,
        ],$code);
    }

    public function changeStatus(Request $request,Functionality $functionality,$status)
    {
        $auth           =   AuthHelper::checkAuth();
        $user           =   $auth->user;
        $isSuperAdmin   =   $auth->isSuperAdmin;
        $message        =   trans('messages.un_authorized');
        $type           =   'error';
        $code           =   401;

        if ($isSuperAdmin)
        {
            $message    =   trans("Functionality not found");
            $code       =   404;

            if ($functionality)
            {
                $message    =   trans('messages.something_went_wrong');
                $type       =   'info';
                $code       =   423;
                $disable    =   $status ==  'false';
                $updated    =   $functionality->update([
                                    'status'  =>  $disable ? false : true,
                                ]);

                if ($updated)
                {
                    $geolocation    =   geoip(Helper::getip());
                    $json           =   json_encode($functionality);
                    $updated_status =   $disable ? 'false' : 'true';

                    Activity::create([
                        'user_id'       =>  $user->id,
                        'type'          =>  'role',
                        'action'        =>  $user->name." updated $functionality->name status to $updated_status",
                        'data'          =>  $json,
                        'level'         =>  'Info',
                        'ip_address'    =>  $geolocation->ip,
                    ]);

                    $message    =   trans('Status Changed Successfully');
                    $type       =   'success';
                    $code       =   423;
                }
            }
        }

        End:
        return response()->json([
            'message'   =>  $message,
            'type'      =>  $type
        ],$code);
    }
}
