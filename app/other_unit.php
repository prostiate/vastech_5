<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class other_unit extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function product()
    {
        return $this->hasMany('App\product');
    }

    public function purchase_delivery_item()
    {
        return $this->hasMany('App\purchase_delivery_item');
    }

    public function purchase_invoice_item()
    {
        return $this->hasMany('App\purchase_invoice_item');
    }

    public function purchase_order_item()
    {
        return $this->hasMany('App\purchase_order_item');
    }

    public function purchase_quote_item()
    {
        return $this->hasMany('App\purchase_quote_item');
    }

    public function purchase_return_item()
    {
        return $this->hasMany('App\purchase_return_item');
    }

    public function sale_delivery_item()
    {
        return $this->hasMany('App\sale_delivery_item');
    }

    public function sale_invoice_item()
    {
        return $this->hasMany('App\sale_invoice_item');
    }

    public function sale_order_item()
    {
        return $this->hasMany('App\sale_order_item');
    }

    public function sale_quote_item()
    {
        return $this->hasMany('App\sale_quote_item');
    }

    public function sale_return_item()
    {
        return $this->hasMany('App\sale_return_item');
    }

    public function wip()
    {
        return $this->hasMany('App\wip');
    }
}
