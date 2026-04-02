<?php

namespace App\Http\Controllers;

use App\Helper\AuthHelper;
use App\Helper\NotificationHelper;
use App\Models\ProjectRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectRoleController extends Controller
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

    public function index(Request $request)
    {
        $auth    =   AuthHelper::checkAuth();
        $user    =   $auth->user;
        $allowed =   array_key_exists("PROJECT",$auth->func);

        if($allowed || $auth->role == "super_admin")
        {
            if ($request->ajax())
            {
                $project_roles  =   ProjectRole::latest()->paginate(10);

                return view('includes.tables.project-role.table', compact(
                    'project_roles',
                    'auth',
                ));
            }
            else
            {
                return view('project-role.index',compact(
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
        $allowed        =   array_key_exists("PROJECTCRT",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $rules = [
                'name'  => ['required', 'unique:project_roles,name'],
            ];

            $request->validate($rules);

            $create_data    =   [
                'name'     =>  $request->name,
            ];

           $created    =   ProjectRole::create($create_data);

            $message    =   trans('Something went wrong while creating role');
            $type       =   'error';
            $code       =   500;

            if ($created)
            {
                $message    =   trans('Role created Successfully');
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

    public function update(Request $request, $id)
    {
        $auth       =   AuthHelper::checkAuth();
        $message    =   trans('messages.un_authorized');
        $type       =   'info';
        $code       =   401;
        $success    =   false;
        $allowed    =   array_key_exists("PROJECTUPD",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $project_role    =   ProjectRole::find($id);
            $message        =   trans('role not found');
            $type           =   'info';
            $code           =   404;

            if($project_role)
            {
                $rules = [
                    'name' => ['required','string','max:255',Rule::unique('project_roles', 'name')->ignore($project_role->id)],
                ];

                $request->validate($rules);

                $updated_data    =   [
                    'name'     =>  $request->name,
                ];

                $updated    =   $project_role->update($updated_data);

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
        $allowed    =   array_key_exists("PROJECTDLT",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $project_role   =   ProjectRole::find($id);
            $message        =   trans('Role not found');
            $type           =   'info';
            $code           =   404;

            if($project_role)
            {
                $deleted    =   $project_role->delete();
                $message    =   trans('Something went wrong while deleting role');
                $type       =   'error';
                $code       =   500;

                if ($deleted)
                {
                    $message    =   trans('role deleted Successfully');
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
}
