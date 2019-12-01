<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class purchase_invoice_po extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function purchase_invoice()
    {
        return $this->belongsTo('App\purchase_invoice');
    }

    public function purchase_order()
    {
        return $this->belongsTo('App\purchase_order');
    }
}
