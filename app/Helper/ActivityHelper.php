<?php

namespace App\Helper;

use Throwable;
use Carbon\Carbon;
use App\Helper\AuthHelper;
use App\Models\Activity;
use App\Models\LoginActivities;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ActivityHelper
{
    public static function activityDetail($auth,$detail,$needToBeCreated=true,$IqId=null, $close=false)
    {
        $auth       =   $auth ? $auth : AuthHelper::checkAuth();
        $auth_user  =   $auth->user;
        $user       =   $auth->isMerchantUser && $auth->merchant ? $auth->merchant     : $auth->user;
        $message    =   trans('messages.un_authorized');
        $success    =   false;
        $type       =   'info';
        $code       =   401;
        $activity   =   null;

        if($auth_user)
        {
            try
            {
                $activity    =   Activity::where([
                    'user_id'   =>  $auth_user->id,
                    'state'     =>  false,
                    'type'      =>  'cvu_withdrawal',
                ])->whereDate('created_at', Carbon::today())->latest()->first();

                if(!$activity)
                {
                    $roles          =   config('defaults.user_roles');
                    $geolocation    =   geoip(Helper::getip());
                    $json           =   json_encode($detail);
                    $message        =   trans('Something went wrong while creating activity');
                    $type           =   'error';
                    $code           =   500;

                    $created    =   Activity::create([
                        'user_id'       =>  $auth_user->id,
                        'type'          =>  'cvu_withdrawal',
                        'action'        =>  $auth->isStaffCvuFinance
                                            ? "Merchant $user->email ID($user->id) Staff $auth_user->email ID($auth_user->id) Role {$roles['r_'.$auth_user->user_type]} has initiated cvu withdrawal"
                                            : "Merchant $user->email ID($user->id) has initiated cvu withdrawal",
                        'data'          =>  $json,
                        'level'         =>  'info',
                        'state'         =>  false,
                        'ip_address'    =>  $geolocation->ip,
                    ]);

                    if ($created)
                    {
                        $created->activity_details()->create([
                            'detail' => json_encode(['message' => $created->action]),
                        ]);
                    }
                }
                else
                {
                    if($needToBeCreated)
                    {
                        $created    =   $activity->activity_details()->create([
                            'detail' => json_encode($detail),
                        ]);
                    }

                    $up_data    =   [
                        'state'     =>  $close ? $close : $activity->state
                    ];

                    if($IqId)
                    {
                        $up_data    +=  [
                            'action'    =>  $activity->action . ' IQID: ' . $IqId,
                            'trx_id'    =>  $IqId
                        ];
                    }

                    $updated_activity   =   $activity->update($up_data);
                }

                // $message    =   trans('Something went wrong while creating activity');
                // $type       =   'error';
                // $code       =   500;

                // if($created)
                // {
                    $message        =   trans('Activity created successfully');
                    $type           =   'success';
                    $code           =   200;
                    $success        =   true;
                //}
            }
            catch (\Throwable $th)
            {
                Log::critical([
                    'message'       =>  'Something went wrong while creating activity',
                    'error'         =>  $th->getMessage(),
                    "line_number"   =>  $th->getLine(),
                ]);
            }
        }

        return response()->json([
            'success'   =>  $success,
            'type'      =>  $type,
            'message'   =>  $message,
        ],$code);
    }

    public static function createLoginActivity($user = null, $message, $request,$clear_session = false)
    {
        $geolocation    =   geoip(Helper::getip());

        if (is_string($request->fp_data))
        {
            $fp_data = json_decode($request->fp_data, true);

            $request->merge([
                'fp_data' => $fp_data,
            ]);
        }

        try
        {
            $email      =   $user ? $user->email    : $request->email;
            $u_id       =   $user ? $user->id       : null;
            $ac_data    =   [
                                'email'     => $email,
                                'user_id'   => $u_id,
                                'message'   => $message,
                                'data'      => isset($request->fp_data) ? $request->fp_data : null,
                            ];

            if(session()->has('login_activity_id'))
            {
                $login_activity_id      =   Session::get('login_activity_id');
                $existing_activity      =   LoginActivities::where('token', $login_activity_id)->first();

                if($existing_activity && $existing_activity->user_id == $u_id)
                {
                    $existingData           =   json_decode($existing_activity->data, true);
                    $existingData[]         =   $ac_data;
                    $existingData           =   array_values($existingData);

                    $existing_activity->update([
                        'user_id'   =>  $u_id,
                        'data'      =>  json_encode($existingData),
                    ]);
                }
                else
                {
                    goto create_new;
                }
            }
            else
            {
                create_new:

                $token      =   Helper::createLoginActivityUuId();

                Session::put('login_activity_id', $token);

                LoginActivities::create([
                    'user_id'       =>  $u_id,
                    'action'        =>  "$email wants to Login",
                    'data'          =>  json_encode([$ac_data]),
                    'token'         =>  $token,
                    'ip_address'    =>  $geolocation->ip,
                ]);
            }

            if($clear_session)
            {
                Session::forget('login_activity_id');
                $request->session()->regenerate();
            }
        }
        catch (\Throwable $th)
        {
            $response['log_message']    =   trans('Something went wrong while creating activity');
            $response['log_error']      =   "Error: ".$th->getMessage()." Line: ".$th->getLine();
            $response['log_data']       =   $request->all();

            Log::critical($response);
        }
    }
}
?>
