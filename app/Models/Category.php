<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function child()
    {
        return $this->hasMany(Category::class , 'parent' , 'id');
    }


    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
