<?php

namespace App\Http\Controllers;

use App\Helper\AuthHelper;
use App\Helper\NotificationHelper;
use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
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
        $allowed =   array_key_exists("INVOICE",$auth->func);

        if($allowed || $auth->role == "super_admin")
        {
            if ($request->ajax())
            {
                $Invoices  =   Invoice::with('project', 'assignee', 'assigned')->latest()->paginate(10);

                return view('includes.tables.Invoice.table', compact(
                    'Invoices',
                    'auth',
                ));
            }
            else
            {
                $projects    =   Project::latest()->paginate(10);
                return view('Invoice.index',compact(
                    'auth',
                    'projects',
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
        $allowed        =   array_key_exists("INVOICECRT",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $rules = [
                'project'       =>  ['required', 'exists:projects,id'],
                'amount'        =>  ['required', 'numeric', 'min:0'],       // amount should be a positive number
                'description'   =>  ['nullable', 'string', 'max:255'],      // description optional, string max 255
                'status'        =>  ['required', Rule::in(['unpaid','partial','paid'])],  // allowed statuses
                'due_date'      =>  ['required', 'date', 'after_or_equal:today'],       // due_date must be today or future
            ];

            $request->validate($rules);

            if(!in_array($auth->role, ["client", "team"]))
            {
                $Invoice_create  =   [
                    'project_id'    =>  $request->project ?? null,
                    'invoice_number'=>  $auth->user->id,
                    'amount'        =>  $request->assigned_to ,
                    'description'   =>  $request->title,
                    'status'        =>  $request->description,
                    'due_date'      =>  $request->due_date,
                ];

                $created    =   Invoice::create($Invoice_create);
                $message    =   trans('Something went wrong while creating invoice');
                $type       =   'error';
                $code       =   500;

                if ($created)
                {
                    $message    =   trans('Invoice created Successfully');
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
        $allowed    =   array_key_exists("INVOICEUPD",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $Invoice       =   Invoice::find($id);
            $message    =   trans('Invoice not found');
            $type       =   'info';
            $code       =   404;

            if($Invoice)
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

                $Invoice_updated   =   [
                    'project_id'    =>  $request->project ?? null,
                    'invoice_number'=>  $auth->user->id,
                    'amount'        =>  $request->assigned_to ,
                    'description'   =>  $request->title,
                    'status'        =>  $request->description,
                    'due_date'      =>  $request->due_date,
                ];

                $updated    =   $Invoice->update($Invoice_updated);
                $message    =   trans('Something went wrong while updating invoice');
                $type       =   'error';
                $code       =   500;

                if ($updated)
                {
                    $message    =   trans('Invoice updated Successfully');
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
