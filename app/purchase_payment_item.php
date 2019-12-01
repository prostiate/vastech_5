<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class purchase_payment_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function purchase_payment()
    {
        return $this->belongsTo('App\purchase_payment');
    }

    public function purchase_invoice()
    {
        return $this->belongsTo('App\purchase_invoice', 'purchase_invoice_id');
    }
}
