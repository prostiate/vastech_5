<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class other_product_category extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function product()
    {
        return $this->hasMany('App\product');
    }
}
