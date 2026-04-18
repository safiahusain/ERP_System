<?php

namespace App\Http\Controllers;

use App\Helper\AuthHelper;
use App\Helper\NotificationHelper;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectController extends Controller
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
                $projects  =   Project::latest()->paginate(10);

                return view('includes.tables.project.table', compact(
                    'projects',
                    'auth',
                ));
            }
            else
            {
                $clients    =   User::clients()->select('id', 'email')->get()->toArray();
                $managers   =   User::managers()->select('id', 'email')->get()->toArray();
                return view('project.index',compact(
                    'managers',
                    'clients',
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
                'client'        => ['required', 'exists:users,id'],
                'manager'       => ['required', 'exists:users,id'],
                'title'         => ['required', 'string', 'max:255'],
                'description'   => ['required', 'string', 'max:255'],
                'status'        => ['required', 'string', 'max:255'],
                'start_date'    => ['required', 'date'],
                'end_date'      => ['required', 'date', 'after_or_equal:start_date'],
            ];

            $request->validate($rules);

            $create_data    =   [
                'client_id'     =>  $request->client,
                'manager_id'    =>  $request->manager,
                'title'         =>  $request->title,
                'description'   =>  $request->description,
                'status'        =>  $request->status,
                'start_date'    =>  $request->start_date,
                'end_date'      =>  $request->end_date,
            ];

           $created    =   Project::create($create_data);

            $message    =   trans('Something went wrong while creating project');
            $type       =   'error';
            $code       =   500;

            if ($created)
            {
                $message    =   trans('Project created Successfully');
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
            $project    =   Project::find($id);
            $message    =   trans('Project not found');
            $type       =   'info';
            $code       =   404;

            if($project)
            {
                $rules = [
                    'client'        => ['required', 'exists:users,id'],
                    'manager'       => ['required', 'exists:users,id'],
                    'title'         => ['required', 'string', 'max:255'],
                    'description'   => ['required', 'string'],
                    'status'        => ['required', 'string', 'max:255'],
                    'start_date'    => ['required', 'date'],
                    'end_date'      => ['required', 'date', 'after_or_equal:start_date'],
                ];

                $request->validate($rules);

                $updated_data    =   [
                    'client_id'     =>  $request->client,
                    'manager_id'    =>  $request->manager,
                    'title'         =>  $request->title,
                    'description'   =>  $request->description,
                    'status'        =>  $request->status,
                    'start_date'    =>  $request->start_date,
                    'end_date'      =>  $request->end_date,
                ];

                $updated    =   $project->update($updated_data);

                $message    =   trans('Something went wrong while updating project');
                $type       =   'error';
                $code       =   500;

                if ($updated)
                {
                    $message    =   trans('Project updated Successfully');
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
            $project    =   Project::find($id);
            $message    =   trans('Project not found');
            $type       =   'info';
            $code       =   404;

            if($project)
            {
                $deleted    =   $project->delete();
                $message    =   trans('Something went wrong while deleting project');
                $type       =   'error';
                $code       =   500;

                if ($deleted)
                {
                    $message    =   trans('Project deleted Successfully');
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

    public function view(Request $request, $id)
    {
        $auth       =   AuthHelper::checkAuth();
        $message    =   trans('messages.un_authorized');
        $type       =   'info';
        $code       =   401;
        $success    =   false;
        $allowed    =   array_key_exists("PROJECTVIEW",$auth->func);
        $html_data  =   "";

        if ($allowed || $auth->role == "super_admin")
        {
            $project    =   Project::find($id);
            $message    =   trans('Project not found');
            $type       =   'info';
            $code       =   404;

            if($project)
            {
                $badge = $project->status == "pending"
                            ? "status-pending"
                            : ($project->status == "active"
                                ? "status-active"
                                : ($project->status == "completed"
                                    ? "status-completed"
                                    : "status-default"));

                $start = $project->start_date
                            ? Carbon::parse($project->start_date)->format('d M')
                            : '-';

                $end   = $project->end_date
                            ? Carbon::parse($project->end_date)->format('d M')
                            : '-';

                $project_json = htmlspecialchars(json_encode($project), ENT_QUOTES, 'UTF-8');

                $html_data  .=  "<div class='project-card'>

                                    <!-- Header -->
                                    <div class='project-header'>
                                        <h5 class='project-title'>Project: {$project->title}</h5>

                                        <div class='project-actions'>";

                                            if (array_key_exists("PROJECTUPD", $auth->func))
                                            {
                                                $html_data .= "
                                                <a href='javascript:void(0)'
                                                    onclick='assign_to_update(this, {$project_json})'
                                                    title='Update'>
                                                    <img src='".asset('images/icons/edit.png')."' class='filters-btn'>
                                                </a>";
                                            }

                                            if (array_key_exists("PROJECTDLT", $auth->func))
                                            {
                                                $html_data .= "
                                                <a href='javascript:void(0)'
                                                    onclick='set_delete_recode_id({$project->id}, \"project\")'
                                                    title='Delete'>
                                                    <img src='".asset('images/icons/delete.png')."' class='filters-btn'>
                                                </a>";
                                            }

                $html_data  .=          "</div>
                                    </div>

                                    <!-- Details -->
                                    <div class='project-body'>

                                        <div class='status-row'>
                                            <span class='label'>Status</span>
                                            <span class='badge {$badge}'>".ucfirst($project->status)."</span>
                                        </div>

                                        <div class='info-grid'>
                                            <div>
                                                <span class='label'>Client</span>
                                                <p>".optional($project->client)->name."</p>
                                            </div>

                                            <div>
                                                <span class='label'>Manager</span>
                                                <p>".optional($project->manager)->name."</p>
                                            </div>

                                            <div>
                                                <span class='label'>Start</span>
                                                <p>{$start}</p>
                                            </div>

                                            <div>
                                                <span class='label'>End</span>
                                                <p>{$end}</p>
                                            </div>
                                        </div>

                                        <hr>

                                        <!-- Tabs -->
                                        <div class='project-tabs'>
                                            <a href='#' class='tab active'>Overview</a>
                                            <a href='#' class='tab'>Team</a>
                                            <a href='#' class='tab'>Tasks</a>
                                            <a href='#' class='tab'>Files</a>
                                            <a href='#' class='tab'>Invoices</a>
                                        </div>

                                    </div>
                                </div>";

                $clients    =   User::clients()->select('id', 'email')->get()->toArray();
                $managers   =   User::managers()->select('id', 'email')->get()->toArray();
                return view('project.view-detail', compact(
                    'html_data',
                    'managers',
                    'clients',
                    'project',
                ));
            }
        }

        return response()->json([
            'success'   =>  $success,
            'type'      =>  $type,
            'message'   =>  $message,
        ],$code);
    }
}
