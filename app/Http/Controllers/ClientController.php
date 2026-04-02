<?php

namespace App\Http\Controllers;

use App\Helper\AuthHelper;
use App\Helper\NotificationHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rule;

class ClientController extends Controller
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
        $allowed =   array_key_exists("CLIENT",$auth->func);

        if($allowed || $auth->role == "super_admin")
        {
            if ($request->ajax())
            {
                $clients  =   User::where('role_tag', 'client')->with('detail')->latest()->paginate(10);

                return view('includes.tables.client.table', compact(
                    'clients',
                    'auth',
                ));
            }
            else
            {
                return view('client.index',compact(
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
        $allowed        =   array_key_exists("CLIENTCRT",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $rules          =   [
                'name'              =>  ['required', 'string', 'max:255'],
                'email'             =>  ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password'          =>  ['required', 'string'],
                'contact'           =>  ['required', 'regex:/^[0-9\-\+]+$/'],
                'address'           =>  ['required', 'max:255'],
                'company_name'      =>  ['required', 'string', 'max:255'],
                'company_contact'   =>  ['required', 'regex:/^[0-9\-\+]+$/'],
                'company_address'   =>  ['required', 'max:255'],
            ];

            $request->validate($rules);

            $password       =   Hash::make($request->password);
            $client_create  =   [
                'name'              =>  $request->name,
                'email'             =>  $request->email,
                'password'          =>  $password,
                'phone'             =>  $request->contact,
                'address'           =>  $request->address,
                'role_tag'          =>  "client",
                'company_name'      =>  $request->company_name,
                'company_contact'   =>  $request->company_contact,
                'company_address'   =>  $request->company_address,
            ];

            $created    =   User::create($client_create);

            $message    =   trans('Something went wrong while creating client');
            $type       =   'error';
            $code       =   500;

            if ($created)
            {
                $message    =   trans('Client created Successfully');
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
        $allowed    =   array_key_exists("CLIENTUPD",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $client     =   User::find($id);
            $message    =   trans('Client not found');
            $type       =   'info';
            $code       =   404;

            if($client)
            {
                $rules          =   [
                    'name'              =>  ['required', 'string', 'max:255'],
                    'email'             =>  ['required', 'string', 'email', 'max:255',  Rule::unique('users', 'email')->ignore($client->id)],
                    'contact'           =>  ['required', 'regex:/^[0-9\-\+]+$/'],
                    'address'           =>  ['required', 'max:255'],
                    'company_name'      =>  ['required', 'string', 'max:255'],
                    'company_contact'   =>  ['required', 'regex:/^[0-9\-\+]+$/'],
                    'company_address'   =>  ['required', 'max:255'],
                ];

                $request->validate($rules);

                $client_updated   =   [
                    'name'              =>  $request->name,
                    'email'             =>  $request->email,
                    'phone'             =>  $request->contact,
                    'address'           =>  $request->address,
                    'company_name'      =>  $request->company_name,
                    'company_contact'   =>  $request->company_contact,
                    'company_address'   =>  $request->company_address,
                ];

                $updated    =   $client->update($client_updated);

                $message    =   trans('Something went wrong while updating client');
                $type       =   'error';
                $code       =   500;

                if ($updated)
                {
                    $message    =   trans('Client updated Successfully');
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
        $allowed    =   array_key_exists("CLIENTDLT",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $client     =   User::find($id);
            $message    =   trans('Client not found');
            $type       =   'info';
            $code       =   404;

            if($client)
            {
                $deleted    =   $client->delete();
                $message    =   trans('Something went wrong while deleting client');
                $type       =   'error';
                $code       =   500;

                if ($deleted)
                {
                    $message    =   trans('Client deleted Successfully');
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

    public function setActiveToggle(Request $request, $id, $status)
    {
        $auth       =   AuthHelper::checkAuth();
        $message    =   trans('messages.un_authorized');
        $type       =   'info';
        $code       =   401;
        $allowed    =   array_key_exists("ClientACTTOGGLE",$auth->func);
        $htm_text   =   "";

        if ($allowed || $auth->role == "super_admin")
        {
            if ($request->ajax())
            {
                $code       =   404;
                $message    =   "Client not found";
                $client     =   User::find($id);

                if ($client)
                {
                    $status     =   $status ==  "true"  ?   1 : 0;
                    $message    =   "Client status is already updated";
                    $type       =   'info';
                    $code       =   423;

                    if($client->status != $status)
                    {
                        $updates = $client->update([
                            "status" => $status,
                        ]);

                        $message    =   "Something went wrong while updating client status";
                        $type       =   'error';
                        $code       =   500;

                        if ($updates)
                        {
                            $message    =   "Client status updated successfully";
                            $type       =   'success';
                            $code       =   200;
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
}
