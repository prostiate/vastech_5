<?php

namespace App\Model\purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class purchase_invoice_po_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'qty' => 'float',
        'qty_remaining' => 'float',
    ];

    public function purchase_invoice()
    {
        return $this->belongsTo('App\Model\purchase\purchase_invoice');
    }

    public function purchase_order()
    {
        return $this->belongsTo('App\Model\purchase\purchase_order');
    }

    public function purchase_order_item()
    {
        return $this->belongsTo('App\Model\purchase\purchase_order_item');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    }
}
