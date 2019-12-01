<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class contact extends Model
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

    public function purchase_payment()
    {
        return $this->hasMany('App\purchase_payment');
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

    public function sale_payment()
    {
        return $this->hasMany('App\sale_payment');
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

    public function spk()
    {
        return $this->hasMany('App\spk');
    }

    public function wip()
    {
        return $this->hasMany('App\wip');
    }

    public function stock_adjustment()
    {
        return $this->hasMany('App\stock_adjustment');
    }

    public function expense()
    {
        return $this->hasMany('App\expense');
    }

    public function cashbank()
    {
        return $this->hasMany('App\cashbank');
    }

    public function coa_detail()
    {
        return $this->hasMany('App\coa_detail');
    }

    public function other_transaction()
    {
        return $this->hasMany('App\other_transaction');
    }

    public function coaPayable()
    {
        return $this->belongsTo('App\coa', 'account_payable_id');
    }

    public function coa_payable()
    {
        return $this->belongsTo('App\coa', 'account_payable_id');
    }

    public function coaReceivable()
    {
        return $this->belongsTo('App\coa', 'account_receivable_id');
    }

    public function term()
    {
        return $this->belongsTo('App\other_term');
    }
}
