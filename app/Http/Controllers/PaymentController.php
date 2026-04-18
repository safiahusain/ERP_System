<?php

namespace App\Http\Controllers;

use App\Helper\AuthHelper;
use App\Helper\NotificationHelper;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
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
    public function index(Request $request, $id = null)
    {
        $auth    =   AuthHelper::checkAuth();
        $user    =   $auth->user;
        $allowed =   array_key_exists("PAYMENT",$auth->func);

        if($allowed || $auth->role == "super_admin")
        {
            if ($request->ajax())
            {
                $payments   =   $id
                                ?   Payment::where('invoice_id', $id)->latest()->paginate(10)
                                :   Payment::latest()->paginate(10);

                return view('includes.tables.payment.table', compact(
                    'payments',
                    'auth',
                ));
            }
            else
            {
                $invoice   =   Invoice::find($id);

                return view('payment.index',compact(
                    'id',
                    'auth',
                    'invoice',
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
        $allowed        =   array_key_exists("PAYMENTCRT",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $rules = [
                'invoice_id'    =>  'required',
                'amount'        =>  'required|numeric',
                'payment_method'=>  'required|in:cash,bank,paypal',
            ];

            $request->validate($rules);

            $payment_create  =   [
                'invoice_id'     =>  $request->invoice_id,
                'amount'         =>  $request->amount,
                'reference'      =>  $request->reference ?? null,
                'payment_method' =>  $request->payment_method,
            ];

            $created    =   Payment::create($payment_create);
            $message    =   trans('Something went wrong while creating payment');
            $type       =   'error';
            $code       =   500;

            if ($created)
            {
                $message    =   trans('Payment created Successfully');
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
        $allowed    =   array_key_exists("PAYMENTUPD",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $payment    =   Payment::find($id);
            $message    =   trans('Payment not found');
            $type       =   'info';
            $code       =   404;

            if($payment)
            {
                $rules          =   [
                    'invoice_id'    =>  'required',
                    'amount'        =>  'required|numeric',
                    'payment_method'=>  'required|in:cash,bank,paypal',
                ];

                $request->validate($rules);

                $payment_updated   =   [
                    'invoice_id'     =>  $request->invoice_id,
                    'amount'         =>  $request->amount,
                    'reference'      =>  $request->reference ?? null,
                    'payment_method' =>  $request->payment_method,
                ];

                $updated    =   $payment->update($payment_updated);
                $message    =   trans('Something went wrong while updating payment');
                $type       =   'error';
                $code       =   500;

                if ($updated)
                {
                    $message    =   trans('Payment updated Successfully');
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
        $allowed    =   array_key_exists("PAYMENTDLT",$auth->func);

        if ($allowed || $auth->role == "super_admin")
        {
            $payment    =   Payment::where(['paid' => '0','id' => $id])->first();
            $message    =   trans('Payment not found');
            $type       =   'info';
            $code       =   404;

            if($payment)
            {
                $deleted    =   $payment->delete();
                $message    =   trans('Something went wrong while deleting payment');
                $type       =   'error';
                $code       =   500;

                if ($deleted)
                {
                    $message    =   trans('Payment deleted Successfully');
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
