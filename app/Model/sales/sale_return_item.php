<?php

namespace App\Model\sales;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sale_return_item extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'qty' => 'float',
        'qty_invoice' => 'float',
        'qty_remaining_invoice' => 'float',
    ];

    public function sale_return()
    {
        return $this->belongsTo('App\Model\sales\sale_return');
    }

    public function sale_invoice_item2()
    {
        return $this->belongsTo('App\Model\sales\sale_invoice_item', 'sale_invoice_item_id');
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
