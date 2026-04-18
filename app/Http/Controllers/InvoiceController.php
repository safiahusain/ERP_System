<?php

namespace App\Http\Controllers;

use App\Helper\AuthHelper;
use App\Helper\NotificationHelper;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;

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
                $invoices  =   Invoice::latest()->paginate(10);

                return view('includes.tables.invoice.table', compact(
                    'invoices',
                    'auth',
                ));
            }
            else
            {
                $clients    =   User::where('role_tag', 'client')->get();
                $projects   =   Project::get();

                return view('invoice.index',compact(
                    'auth',
                    'projects',
                    'clients'
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
        $message        =   trans('messages.un_authorized');
        $type           =   'info';
        $code           =   401;
        $success        =   false;
        $allowed        =   array_key_exists("INVOICECRT",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $rules = [
                'project'   =>  ['required', 'exists:projects,id'],
                'client'    =>  ['required', 'exists:users,id',
                                    Rule::exists('users', 'id')->where(function ($q) {
                                        $q->where('role_tag', 'client'); // sirf team allowed
                                    })
                                ],
                'amount'    =>  'required|numeric'
            ];

            $request->validate($rules);

            if(!in_array($auth->role, ["client", "team"]))
            {
                $invoice_create  =   [
                    'client_id'     =>  $request->client,
                    'project_id'    =>  $request->project,
                    'invoice_number'=>  'INV-' . rand(1000,9999),
                    'total'         =>  $request->amount,
                    'paid'          =>  0,
                    'due'           =>  $request->amount,
                    'status'        =>  'due',
                    'due_date'      =>  $request->due_date,
                    'description'   =>  $request->description
                ];

                $created    =   Invoice::create($invoice_create);
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
            $invoice    =   Invoice::find($id);
            $message    =   trans('Invoice not found');
            $type       =   'info';
            $code       =   404;

            if($invoice)
            {
                $rules          =   [
                    'project'   =>  ['required', 'exists:projects,id'],
                    'client'    =>  ['required', 'exists:users,id',
                                        Rule::exists('users', 'id')->where(function ($q) {
                                            $q->where('role_tag', 'client'); // sirf team allowed
                                        })
                                    ],
                    'amount'    =>  'required|numeric'
                ];

                $request->validate($rules);

                $invoice_updated   =   [
                    'client_id' => $request->client,
                    'project_id' => $request->project,
                    'total' => $request->amount,
                    'due_date' => $request->due_date,
                    'description' => $request->description
                ];

                $updated    =   $invoice->update($invoice_updated);
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

    public function delete(Request $request, $id)
    {
        $auth       =   AuthHelper::checkAuth();
        $message    =   trans('messages.un_authorized');
        $type       =   'info';
        $code       =   401;
        $success    =   false;
        $allowed    =   array_key_exists("INVOICEDLT",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $invoice    =   Invoice::find($id);
            $message    =   trans('Invoice not found');
            $type       =   'info';
            $code       =   404;

            if($invoice)
            {
                $message    =   trans('You are not allowed to delete this invoice as it has payments');
                $type       =   'info';
                $code       =   401;

                if($invoice->payments()->count() == 0)
                {
                    $deleted    =   $invoice->delete();
                    $message    =   trans('Something went wrong while deleting invoice');
                    $type       =   'error';
                    $code       =   500;

                    if ($deleted)
                    {
                        $message    =   trans('Invoice deleted Successfully');
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
}
