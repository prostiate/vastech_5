<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class other_term extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    
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

    public function purchase_quote()
    {
        return $this->hasMany('App\purchase_quote');
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

    public function sale_quote()
    {
        return $this->hasMany('App\sale_quote');
    }

    public function sale_return()
    {
        return $this->hasMany('App\sale_return');
    }

    public function cashbank()
    {
        return $this->hasMany('App\cashbank');
    }

    public function contact()
    {
        return $this->hasMany('App\contact');
    }

    public function expense()
    {
        return $this->hasMany('App\expense');
    }
}
