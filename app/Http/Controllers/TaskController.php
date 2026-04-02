<?php

namespace App\Http\Controllers;

use App\Helper\AuthHelper;
use App\Helper\NotificationHelper;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
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
        $allowed =   array_key_exists("TASK",$auth->func);

        if($allowed || $auth->role == "super_admin")
        {
            if ($request->ajax())
            {
                $tasks  =   Task::with('project', 'assignee', 'assigned')->latest()->paginate(10);

                return view('includes.tables.task.table', compact(
                    'tasks',
                    'auth',
                ));
            }
            else
            {
                $projects    =   Project::latest()->paginate(10);
                $team_members=   User::where('role_tag', 'team')->latest()->paginate(10);
                return view('task.index',compact(
                    'auth',
                    'projects',
                    'team_members'
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
        $allowed        =   array_key_exists("TASKCRT",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $rules          =   [
                'project'       =>  ['required', 'exists:projects,id'],
                'assigned_to'   =>  ['required', 'exists:users,id',
                                        Rule::exists('users', 'id')->where(function ($q) {
                                            $q->where('role_tag', 'team'); // sirf team allowed
                                        })
                                    ],
                'title'         =>  ['required', 'string', 'max:255'],
                'description'   =>  ['required', 'string', 'max:255'],
                'priority'      =>  ['required', Rule::in(['low', 'high'])],
                'status'        =>  ['required', Rule::in(['pending', 'in_progress', 'testing', 'completed'])],
                'due_date'      =>  ['required', 'date'],
            ];

            $request->validate($rules);

            if(!in_array($auth->role, ["client", "team"]))
            {
                $task_create  =   [
                    'project_id'    =>  $request->project ?? null,
                    'assigned_by'   =>  $auth->user->id,
                    'assigned_to'   =>  $request->assigned_to ,
                    'title'         =>  $request->title,
                    'description'   =>  $request->description,
                    'priority'      =>  $request->priority,
                    'status'        =>  $request->status,
                    'due_date'      =>  $request->due_date,
                ];

                $created    =   Task::create($task_create);
                $message    =   trans('Something went wrong while creating task');
                $type       =   'error';
                $code       =   500;

                if ($created)
                {
                    $message    =   trans('Task created Successfully');
                    $type       =   'success';
                    $code       =   202;
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

    public function update(Request $request, $id)
    {
        $auth       =   AuthHelper::checkAuth();
        $message    =   trans('messages.un_authorized');
        $type       =   'info';
        $code       =   401;
        $success    =   false;
        $allowed    =   array_key_exists("TASKUPD",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $task       =   Task::find($id);
            $message    =   trans('Task not found');
            $type       =   'info';
            $code       =   404;

            if($task)
            {
                $rules          =   [
                    'project'       =>  ['required', 'exists:projects,id'],
                    'assigned_to'   =>  ['required', 'exists:users,id',
                                            Rule::exists('users', 'id')->where(function ($q) {
                                                $q->where('role_tag', 'team'); // sirf team allowed
                                            })
                                        ],
                    'title'         =>  ['required', 'string', 'max:255'],
                    'description'   =>  ['required', 'string', 'max:255'],
                    'priority'      =>  ['required', Rule::in(['low', 'high'])],
                    'status'        =>  ['required', Rule::in(['pending', 'in_progress', 'testing', 'completed'])],
                    'due_date'      =>  ['required', 'date'],
                ];

                $request->validate($rules);

                $task_updated   =   [
                    'project_id '   =>  $request->project ?? null,
                    'assigned_by '  =>  $auth->user->id,
                    'assigned_to '  =>  $request->assigned_to ,
                    'title'         =>  $request->title,
                    'description'   =>  $request->description,
                    'priority'      =>  $request->priority,
                    'status'        =>  $request->status,
                    'due_date'      =>  $request->due_date,
                    'completed_at'  =>  $request->completed_at,
                ];

                $updated    =   $task->update($task_updated);
                $message    =   trans('Something went wrong while updating task');
                $type       =   'error';
                $code       =   500;

                if ($updated)
                {
                    $message    =   trans('Task updated Successfully');
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
        $allowed    =   array_key_exists("TASKDLT",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $task       =   Task::find($id);
            $message    =   trans('Task not found');
            $type       =   'info';
            $code       =   404;

            if($task)
            {
                $deleted    =   $task->delete();
                $message    =   trans('Something went wrong while deleting task');
                $type       =   'error';
                $code       =   500;

                if ($deleted)
                {
                    $message    =   trans('Task deleted Successfully');
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
