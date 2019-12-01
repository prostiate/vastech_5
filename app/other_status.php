<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class other_status extends Model
{
    protected $guarded = [];

    public function purchase_delivery()
    {
        return $this->hasMany('App\purchase_delivery');
    }

    public function purchase_order()
    {
        return $this->hasMany('App\purchase_order');
    }

    public function purchase_invoice()
    {
        return $this->hasMany('App\purchase_invoice');
    }

    public function purchase_payment()
    {
        return $this->hasMany('App\purchase_payment');
    }

    public function sale_delivery()
    {
        return $this->hasMany('App\sale_delivery');
    }

    public function sale_order()
    {
        return $this->hasMany('App\sale_order');
    }

    public function sale_invoice()
    {
        return $this->hasMany('App\sale_invoice');
    }

    public function expense()
    {
        return $this->hasMany('App\expense');
    }

    public function production_one()
    {
        return $this->hasMany('App\production_one');
    }

    public function other_transaction()
    {
        return $this->hasMany('App\other_transaction');
    }

    public function cashbank()
    {
        return $this->hasMany('App\cashbank');
    }
}
