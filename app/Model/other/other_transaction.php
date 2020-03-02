<?php

namespace App\Model\other;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class other_transaction extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function purchase_quote()
    {
        return $this->hasMany('App\Model\purchase\purchase_quote');
    }

    public function purchase_order()
    {
        return $this->hasMany('App\Model\purchase\purchase_order');
    }

    public function purchase_delivery()
    {
        return $this->hasMany('App\Model\purchase\purchase_delivery');
    }

    public function purchase_invoice()
    {
        return $this->hasMany('App\Model\purchase\purchase_invoice');
    }

    public function purchase_payment()
    {
        return $this->hasMany('App\Model\purchase\purchase_payment');
    }

    public function purchase_return()
    {
        return $this->hasMany('App\Model\purchase\purchase_return');
    }

    public function sale_quote()
    {
        return $this->hasMany('App\Model\sales\sale_quote');
    }

    public function sale_order()
    {
        return $this->hasMany('App\Model\sales\sale_order');
    }

    public function sale_delivery()
    {
        return $this->hasMany('App\Model\sales\sale_delivery');
    }

    public function sale_invoice()
    {
        return $this->hasMany('App\Model\sales\sale_invoice');
    }

    public function sale_payment()
    {
        return $this->hasMany('App\Model\sales\sale_payment');
    }

    public function sale_return()
    {
        return $this->hasMany('App\Model\sales\sale_return');
    }

    public function expense()
    {
        return $this->hasMany('App\Model\expense\expense');
    }

    public function stock_adjustment()
    {
        return $this->hasMany('App\Model\stock_adjustment\stock_adjustment');
    }

    public function cashbank()
    {
        return $this->hasMany('App\Model\cashbank\cashbank');
    }

    public function coa_detail()
    {
        return $this->hasMany('App\Model\coa\coa_detail');
    }

    public function production_one()
    {
        return $this->hasMany('App\Model\production\production_one');
    }

    public function spk()
    {
        return $this->hasMany('App\Model\spk\spk');
    }

    public function warehouse_transfer()
    {
        return $this->hasMany('App\Model\warehouse\warehouse_transfer');
    }

    public function ot_contact()
    {
        return $this->belongsTo('App\Model\contact\contact', 'contact');
    }

    public function ot_status()
    {
        return $this->belongsTo('App\Model\other\other_status', 'status');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\other\other_status', 'status');
    }
}
