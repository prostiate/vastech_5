<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class term extends Model
{
    public function product_quote()
    {
        return $this->hasMany('App\product_quote');
    } 
    public function product_order()
    {
        return $this->hasMany('App\product_order');
    } 
    public function product_delivery()
    {
        return $this->hasMany('App\product_delivery');
    } 
    public function product_invoice()
    {
        return $this->hasMany('App\product_invoice');
    } 
}
