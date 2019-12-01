<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class other_transaction extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function purchase_quote()
    {
        return $this->hasMany('App\purchase_quote');
    }

    public function purchase_order()
    {
        return $this->hasMany('App\purchase_order');
    }

    public function purchase_delivery()
    {
        return $this->hasMany('App\purchase_delivery');
    }

    public function purchase_invoice()
    {
        return $this->hasMany('App\purchase_invoice');
    }

    public function purchase_payment()
    {
        return $this->hasMany('App\purchase_payment');
    }

    public function purchase_return()
    {
        return $this->hasMany('App\purchase_return');
    }

    public function sale_quote()
    {
        return $this->hasMany('App\sale_quote');
    }

    public function sale_order()
    {
        return $this->hasMany('App\sale_order');
    }

    public function sale_delivery()
    {
        return $this->hasMany('App\sale_delivery');
    }

    public function sale_invoice()
    {
        return $this->hasMany('App\sale_invoice');
    }

    public function sale_payment()
    {
        return $this->hasMany('App\sale_payment');
    }

    public function sale_return()
    {
        return $this->hasMany('App\sale_return');
    }

    public function expense()
    {
        return $this->hasMany('App\expense');
    }

    public function stock_adjustment()
    {
        return $this->hasMany('App\stock_adjustment');
    }

    public function cashbank()
    {
        return $this->hasMany('App\cashbank');
    }

    public function coa_detail()
    {
        return $this->hasMany('App\coa_detail');
    }

    public function production_one()
    {
        return $this->hasMany('App\production_one');
    }

    public function spk()
    {
        return $this->hasMany('App\spk');
    }

    public function warehouse_transfer()
    {
        return $this->hasMany('App\warehouse_transfer');
    }

    public function ot_contact()
    {
        return $this->belongsTo('App\contact', 'contact');
    }

    public function ot_status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }

    public function status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }
}
