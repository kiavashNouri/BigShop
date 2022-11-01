<?php


namespace App\Helpers\Cart;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class CartService
{
    protected $cart;
    protected $name = 'default';

    public function __construct()
    {
//        $this->cart = session()->get($this->name) ?? collect([]);
        $this->cart = collect(json_decode(Request::cookie($this->name) , true)) ?? collect([]);
    }

    public function put(array $value , $obj = null)
    {
//        dd($value);

        if(! is_null($obj) && $obj instanceof Model) {
            $value = array_merge($value , [
                'id' => Str::random(10),
                'subject_id' => $obj->id,
                'subject_type' => get_class($obj)
            ]);
        } elseif(! isset($value['id'])) {
            $value = array_merge($value , [
                'id' => Str::random(10)
            ]);
        }

        $this->cart->put($value['id'] , $value);
//                dd($this->cart);
//        اینجا آیتمای کارت نباید relation داشته باشن(subject_id,subject_type حذف میشن) چون متود all خودش با relation میده(این نکته برای update بود)
//        session()->put($this->name , $this->cart);
        Cookie::queue($this->name , $this->cart->toJson() , 60 * 24 * 7 );

        return $this;
    }

    public function update($key , $options)
    {
        $item = collect($this->get($key, false));

        if(is_numeric($options)) {
            $item = $item->merge([
                'quantity' => $item['quantity'] + $options
            ]);
        }

        if(is_array($options)) {
            $item = $item->merge($options);
        }

        $this->put($item->toArray());

        return $this;
    }

    public function delete($key)
    {
//        dd($this->name);
        if( $this->instance('kia-cart')->has($key) ) {
            $this->cart = $this->cart->filter(function ($item) use ($key) {
                if($key instanceof Model) {
                    return ( $item['subject_id'] != $key->id ) && ( $item['subject_type'] != get_class($key) );
                }
                return $key != $item['id'];
            });

//            session()->put($this->name , $this->cart);
            Cookie::queue($this->name , $this->cart->toJson() , 60 * 24 * 7 );

            return true;
        }

        return false;
    }

    public function count($key)
    {
        if(! $this->has($key) ) return 0;

        return $this->get($key)['quantity'];
    }


    public function has($key)
    {
        if($key instanceof Model) {

            return ! is_null(
                $this->cart->where('subject_id' , $key->id)->where('subject_type' , get_class($key))->first()
            );
        }
//        dd($this->cart->firstWhere('id' , $key));

        return ! is_null(
            $this->cart->firstWhere('id' , $key)
        );
    }

    public function get($key , $withRelationShip = true)
    {
        $item = $key instanceof Model
            ? $this->cart->where('subject_id' , $key->id)->where('subject_type' , get_class($key))->first()
            : $this->cart->firstWhere('id' , $key);
//        dd($this->withRelationshipIfExist($item));

        return $withRelationShip ? $this->withRelationshipIfExist($item) : $item;
    }


    public function all()
    {
        $cart = $this->cart;
        $cart = $cart->map(function($item) {
            return $this->withRelationshipIfExist($item);
        });
        return $cart;
    }

    protected function withRelationshipIfExist($item)
    {
        if(isset( $item['subject_id'] ) && isset($item['subject_type']) ) {
            $class = $item['subject_type'];
            $subject = (new $class())->find( $item['subject_id'] );

            $item[strtolower(class_basename($class))] = $subject;

            unset($item['subject_id']);
            unset($item['subject_type']);

            return $item;
        }


        return $item;
    }

    public function instance(string $name)
    {
//        dd($name);
        $this->cart = collect(json_decode(request()->cookie($name) , true)) ?? collect([]);
        $this->name = $name;
        return $this;
    }
}
