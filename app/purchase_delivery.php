<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class purchase_delivery extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function purchase_delivery_item()
    {
        return $this->hasMany('App\purchase_delivery_item');
    }

    public function purchase_order()
    {
        return $this->belongsTo('App\purchase_order', 'selected_po_id');
    }

    public function purchase_invoice()
    {
        return $this->hasMany('App\purchase_invoice');
    }

    public function transaction()
    {
        return $this->belongsTo('App\other_transaction');
    }

    public function contact()
    {
        return $this->belongsTo('App\contact');
    }

    public function term()
    {
        return $this->belongsTo('App\other_term');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\warehouse');
    }

    public function product()
    {
        return $this->belongsTo('App\product');
    }

    public function status()
    {
        return $this->belongsTo('App\other_status', 'status');
    }
}
