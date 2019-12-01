<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class purchase_payment extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function purchase_payment_item()
    {
        return $this->hasMany('App\purchase_payment_item');
    }

    public function purchase_invoice()
    {
        return $this->hasMany('App\purchase_invoice', 'purchase_invoice_id');
    }

    public function contact()
    {
        return $this->belongsTo('App\contact');
    }

    public function coa()
    {
        return $this->belongsTo('App\coa', 'account_id');
    }

    public function payment_method()
    {
        return $this->belongsTo('App\other_payment_methods', 'other_payment_method_id');
    }

    public function transaction()
    {
        return $this->belongsTo('App\other_transaction');
    }

    public function status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }
}
