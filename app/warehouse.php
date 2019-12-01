<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class warehouse extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function warehouse_detail()
    {
        return $this->hasMany('App\warehouse_detail');
    }

    public function stock_adjustment()
    {
        return $this->hasMany('App\stock_adjustment');
    }

    public function purchase_delivery()
    {
        return $this->hasMany('App\purchase_delivery');
    }

    public function purchase_invoice()
    {
        return $this->hasMany('App\purchase_invoice');
    }

    public function purchase_order()
    {
        return $this->hasMany('App\purchase_order');
    }

    public function purchase_return()
    {
        return $this->hasMany('App\purchase_return');
    }

    public function sale_delivery()
    {
        return $this->hasMany('App\sale_delivery');
    }

    public function sale_invoice()
    {
        return $this->hasMany('App\sale_invoice');
    }

    public function sale_order()
    {
        return $this->hasMany('App\sale_order');
    }

    public function sale_return()
    {
        return $this->hasMany('App\sale_return');
    }

    public function warehouse_transfer()
    {
        return $this->hasMany('App\warehouse_transfer');
    }

    public function spk()
    {
        return $this->hasMany('App\spk');
    }

    public function wip()
    {
        return $this->hasMany('App\wip');
    }
}
