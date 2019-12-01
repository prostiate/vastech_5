<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class unit extends Model
{
    public function product()
    {
        return $this->hasMany('App\product');
    } 

    public function purchase_product()
    {
        return $this->hasMany('App\purchase_product');
    } 
}
