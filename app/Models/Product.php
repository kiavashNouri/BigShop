<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function attributes()
    {

//        میخوام از product به attr و از attr به attr value برسم
//        جدول واسط بین product و attr هست که با withPivot میگیم که یک فیلد اضافه هم به ما نشون بده(value_id)

//        این using باعث میشه به کلاسی که گفتیم از pivot بیا extend کن وصل بشه
        return $this->belongsToMany(Attribute::class)->using(ProductAttributeValues::class)->withPivot(['value_id']);
    }
}

