<?php

namespace App\Rules;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;
use Mockery\Exception;

class Recaptcha implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $client=new Client();
            $response=$client->request('POST','https://www.google.com/recaptcha/api/siteverify',[
               'form_params'=>[
                   'secret'=>'6LcW-JAhAAAAAEasU_p92GM8Nv2pIjkdXHlAloaQ',
                   'response'=>$value,
                   'remoteip'=>request()->ip()
               ]
            ]);
            $response=json_decode($response->getBody());
            return $response->success;
        }catch(\Exception $e){
            //Todo log an error
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'شما رباتید چرا؟مرد حسابی ما کلی زحمت کشیدیم';
    }
}
