<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;


//باید extends کنه pivot رو
class ProductAttributeValues extends Pivot
{

    public function attribute()
    {
        return $this->belongsTo(Attribute::class , 'attribute_id' , 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class , 'product_id' , 'id');
    }

    public function value()
    {
//        میگه value_id مربوط به AttributeValue میشه
        return $this->belongsTo(AttributeValue::class , 'value_id' , 'id');
    }
}
