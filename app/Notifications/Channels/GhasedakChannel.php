<?php


class GhasedakChannel
{
    public function send($notifiable , Notification $notification)
    {
        if(! method_exists($notification , 'toGhasedakSms')) {
            throw new \Exception('toGhasedakSms not found');
        }

        $data = $notification->toGhasedakSms($notifiable);

        $message = $data['text'];
        $receptor = $data['number'];

        $apiKey = config('services.ghasedak.key');

        try
        {
            $lineNumber = "10008566";;
            $api = new \Ghasedak\GhasedakApi($apiKey);
            $api->SendSimple($receptor,$message,$lineNumber);
        }
        catch(ApiException $e){
            throw $e;
        }
        catch(HttpException $e){
            throw $e;
        }
    }
}

