<?php

namespace App\Helper;

use stdClass;

class NotificationHelper
{
    public static function makeFlashNotification($message,$type)
    {
        $flash    =   new stdClass();

        switch ($type)
        {
            case 'success':
                $flash->title   =   'Success';
                $flash->type    =   'success';
            break;

            case 'error':
                $flash->title   =   'Error';
                $flash->type    =   'error';
            break;

            case 'info':
                $flash->title   =   'Info';
                $flash->type    =   'info';
            break;

            case 'warning':
                $flash->title   =   'Warning';
                $flash->type    =   'warning';
            break;
        }

        $flash->message   =   $message;

        return $flash;
    }
}
?>
