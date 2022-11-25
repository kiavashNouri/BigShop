<?php

namespace Modules\Discount\Entities;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
//    protected $fillable = [];
    protected $guarded=['id'];

    public function product()
    {
        return $this->belongsToMany(Product::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
