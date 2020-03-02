<?php

namespace App\Model\purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class purchase_delivery_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'qty' => 'float',
        'qty_remaining' => 'float',
    ];

    public function purchase_delivery()
    {
        return $this->belongsTo('App\Model\purchase\purchase_delivery');
    }

    public function purchase_order_item()
    {
        return $this->belongsTo('App\Model\purchase\purchase_order_item');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\product\product');
    }

    public function unit()
    {
        return $this->belongsTo('App\Model\other\other_unit');
    }

    public function tax()
    {
        return $this->belongsTo('App\Model\other\other_tax');
    }
}
