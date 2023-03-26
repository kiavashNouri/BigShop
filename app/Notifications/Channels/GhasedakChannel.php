<?php
namespace App\Notifications\Channels;

use Ghasedak\Exceptions\ApiException;
use Ghasedak\Exceptions\HttpException;
use Illuminate\Notifications\Notification;

class GhasedakChannel
{

    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toGhasedakSms')) {
            throw new \Exception('toGhasedakSms not found');
        }

        $data = $notification->toGhasedakSms($notifiable);

        $message = $data['text'];
//        $receptor = $data['number'];

        try {
            $message = "تست ارسال وب سرویس قاصدک";
            $lineNumber = "10008566";
            $receptor = "09190443497";
            $api = new \Ghasedak\GhasedakApi('81ece65fd955ef66a1682f59173f690d14a63f8fb0f6ff1b0824cf296ecd9e6e');
            $api->SendSimple($receptor, $message, $lineNumber);
        } catch (ApiException $e) {
            throw $e;
        } catch (HttpException $e) {
            throw $e;
        }
    }
}

