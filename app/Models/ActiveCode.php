<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveCode extends Model
{
    protected $table='active_code';
    use HasFactory;
    protected $guarded=['id'];
    public $timestamps=false;
    public function scopeGenerateCode($query,$user){

//        روش اول که کد Expired at داره و باقی میمونه تو دیتابیس تا زمانی که تاریخ انقضاش تموم نشه
//        if ($code=$this->getAliveCodeForUser($user)){
//            $code=$code->code;
//        }else{
//            do{
//                $code=mt_rand(10000,999999);
//            }while($this->checkCodeIsUnique($user,$code));
////                store code
//                $user->activeCode()->create([
//                    'code'=>$code,
//                    'expired_at'=>now()->addMinute(10)
//                ]);
//
//        }

//        اینجا هر بار کد عوض میشه


        $user->activeCode()->delete();
        do{
            $code=mt_rand(10000,999999);
        }while($this->checkCodeIsUnique($user,$code));
//                store code
            $user->activeCode()->create([
                'code'=>$code,
                'expired_at'=>now()->addMinute(10)
            ]);
        return $code;
    }
    private function checkCodeIsUnique($user,int $code){
        return $user->activeCode()->where('code',$code)->exists();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    private function getAliveCodeForUser($user)
    {
        return $user->activeCode()->where('expired_at','>',now())->first();
    }

    public function scopeVerifyCode($query,$code,$user)
    {
        return $user->activeCode()->where('code',$code)->where('expired_at','>',now())->exists();
    }
}
